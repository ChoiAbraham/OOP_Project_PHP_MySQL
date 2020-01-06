<?php

namespace App\Controllers;

use App\Core\App;
use App\core\Controller;
use App\Helper\Pagination;
use App\Helper\ValidationForm\Check\PostValidator;
use App\Helper\ValidationForm\Session;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

/*
 * manage Posts
 */
class Postlist extends Controller
{
    protected $postRepository;
    protected $commentRepository;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->postRepository = $factoryRepository->getRepository('post');
        $this->commentRepository = $factoryRepository->getRepository('comment');
    }

    /**
     * list of all valid posts (where valid is 1)
     * @param  string $page
     */
    public function index($page = '1')
    {
        $currentPage = (int)$page;
        $LineNumber = 10;

        $posts = $this->postRepository->posts();
        $pagination = new Pagination($posts, $currentPage, $LineNumber);
        $pageNumber = $pagination->countPage();

        $arrayPage = $pagination->arrayPage($currentPage);

        $limit = $pagination->getLimit();
        $skip = ($currentPage - 1) * $LineNumber;

        $checked = 1;
        $posttable = $this->postRepository->postsByLimit($limit, $skip);

        if ($posttable === false) {
            $this->notFound();
        }

        if (Session::exists('PostSuccess')) {
            $message = Session::flash('PostSuccess');
            $errors = [];
        } else {
            $message = '';
        }

        $link = 'postlist/index';

        $response = $this->renderResponse(
            'post/post.html.twig',
            [
                'message' => $message,
                'posts' => $posttable,
                'pagenumber' => $pageNumber,
                'currentpage' => $currentPage,
                'arraypage' => $arrayPage,
                'link' => $link
            ]
        );
        return $response;
    }

    /**
     * show one Post and its comments
     * @param int $id userId
     */
    public function show($id = '')
    {
        $onePost = $this->postRepository->findById($id);
        $comments = $this->commentRepository->listComments($id);

        $onlyInt = (preg_match('/^[1-9][0-9]*$/', $id)) ? true : false;

        if ($onlyInt === false || $onePost === false || $comments === false) {
            $this->notFound();
        }

        // No Comment Valid By Default
        $noComment = true;
        foreach ($comments as $comment) {
            $commentValid = (int) $comment->getValid();
            if ($commentValid === 1) {
                $noComment = false;
                break;
            }
        }

        $response = $this->renderResponse(
            'post/comment.html.twig',
            [
                'post' => $onePost,
                'comments' => $comments,
                'nocomment' => $noComment
            ]
        );

        return $response;
    }

    /**
     * form to create a post
     * @param  string $id userId
     */
    public function create($id = '')
    {
        $this->userOnly();

        $profil = new PostValidator();
        $token = $profil->checkToken();
        $errors = $profil->inputPost('validateFormPost', $id);

        if (!$errors) {
            $errors = [];
        }

        $response = $this->renderResponse(
            'post/createpost.html.twig',
            [
                'token' => $token,
                'error' => $errors
            ]
        );

        return $response;
    }

    /**
     * form to update a post
     * @param  string $id postId
     */
    public function update($id = '')
    {
        $this->userOnly();

        $post = $this->postRepository->findById($id);

        if ($post === false) {
            $this->notFound();
        }

        $profil = new PostValidator();
        $token = $profil->checkToken();
        $errors = $profil->inputPost('validateUpdateFormPost', $id);

        if (!$errors) {
            $errors = [];
        }

        $response = $this->renderResponse(
            'post/updatepost.html.twig',
            [
                'token' => $token,
                'post' => $post,
                'error' => $errors
            ]
        );

        return $response;
    }

    /**
     * list All posts of an User
     * @param  string $id userId
     */
    public function myPost($id = '')
    {
        $this->userOnly();

        $myPosts = $this->postRepository->findByUserId($id);

        if ($myPosts === false) {
            $this->notFound();
        }

        if (Session::exists('updateSuccess')) {
            $message = Session::flash('updateSuccess');
        } else {
            $message = '';
        }


        $response = $this->renderResponse(
            'post/mypost.html.twig',
            [
                'mypost' => $myPosts,
                'message' => $message
            ]
        );

        return $response;
    }
}
