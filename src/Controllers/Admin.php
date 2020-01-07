<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Helper\ValidationForm\Session;
use App\Helper\Pagination;
use App\Helper\ValidationForm\Input;
use App\Helper\ValidationForm\Check\Validator;
use App\Helper\ValidationForm\Check\PostValidator;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\CountRepository;

/**
 * manages all Admin pages
 */
class Admin extends Controller
{
    protected $postRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $countRepository;

    protected $validator;

    public function __construct()
    {
        $factoryRepository = App::getInstance();
        $this->postRepository = $factoryRepository->getRepository('post');
        $this->commentRepository = $factoryRepository->getRepository('comment');
        $this->userRepository = $factoryRepository->getRepository('user');
        $this->countRepository = $factoryRepository->getRepository('Count');
        $this->validator = new Validator();
    }

    public function error404()
    {
        $this->adminOnly();

        $response = $this->renderResponse(
            'admin/404.html.twig',
            [
            ]
        );
        return $response;
    }

    public function dashboard()
    {
        $this->adminOnly();
        $numbers = $this->countRepository->countUserPostComment();

        if ($numbers === false) {
            $this->notFoundAdmin();
        }

        if (Session::exists('LogAdminSuccess')) {
            $message = Session::flash('LogAdminSuccess');
        } else {
            $message = '';
        }

        $response = $this->renderResponse(
            'admin/dashboard.html.twig',
            [
                'message' => $message,
                'number' => $numbers
            ]
        );
        return $response;
    }

    /**
     * list all users
     * @param  string $page
     */
    public function user($page = '1')
    {
        $this->adminOnly();

        //Ajax token csrf
        $token = $this->validator->checkToken();

        $currentPage = (int)$page;
        $LineNumber = 20;

        $users = $this->userRepository->listUsers();

        if ($users === false) {
            $this->notFoundAdmin();
        }

        $pagination = new Pagination($users, $currentPage, $LineNumber);
        $pageNumber = $pagination->countPage();

        $arrayPage = $pagination->arrayPage($currentPage);

        $limit = $pagination->getLimit();
        $skip = ($currentPage - 1) * $LineNumber;

        $checked = 1;
        //Default, list Users By Date
        $usertable = $this->userRepository->listUsersByLimit($limit, $skip);
        $userRoleTable = [];

        foreach ($usertable as $theuser) {
            $userRoleTable[] = $theuser->getRole();
        }
        if (Input::exists()) {
            if (Input::get('radio') ==  'option1') {
                $usertable = $this->userRepository->listUsersByLimit($limit, $skip);
                $checked = 1;
            } elseif (Input::get('radio') == 'option2') {
                $usertable = $this->userRepository->listUsersByUsernameByLimit($limit, $skip);
                $checked = 2;
            }
        }

        $link = 'admin/user';

        $response = $this->renderResponse(
            'admin/userstable.html.twig',
            [
                'users' => $usertable,
                'token' => $token,
                'pagenumber' => $pageNumber,
                'currentpage' => $currentPage,
                'arraypage' => $arrayPage,
                'option' => $checked,
                'link' => $link,
                'userroletable' => $userRoleTable
            ]
        );

        return $response;
    }

    /**
     * list all admins
     * @param  string $page
     */
    public function admin($page = '1')
    {
        $this->adminOnly();

        $currentPage = (int)$page;
        $LineNumber = 20;

        $users = $this->userRepository->listAdmins();

        if ($users === false) {
            $this->notFoundAdmin();
        }

        $pagination = new Pagination($users, $currentPage, $LineNumber);
        $pageNumber = $pagination->countPage();

        $arrayPage = $pagination->arrayPage($currentPage);

        $limit = $pagination->getLimit();
        $skip = ($currentPage - 1) * $LineNumber;

        $checked = 1;
        $usertable = $this->userRepository->listAdminsByLimit($limit, $skip);
        if (Input::exists()) {
            if (Input::get('radio') === 'option1') {
                $usertable = $this->userRepository->listAdminsByLimit($limit, $skip);
                $checked = 1;
            } elseif (Input::get('radio') === 'option2') {
                $usertable = $this->userRepository->listAdminsByUsernameByLimit($limit, $skip);
                $checked = 2;
            }
        }

        $link = 'admin/admin';

        $response = $this->renderResponse(
            'admin/admintable.html.twig',
            [
                'users' => $usertable,
                'pagenumber' => $pageNumber,
                'currentpage' => $currentPage,
                'arraypage' => $arrayPage,
                'option' => $checked,
                'link' => $link
            ]
        );

        return $response;
    }

    /**
     * show all the articles
     * @param  int $page : pagination
     */
    public function articles($page = '1')
    {
        $this->adminOnly();

        $currentPage = (int)$page;
        $LineNumber = 20;

        $users = $this->postRepository->listPosts();

        if ($users === false) {
            $this->notFoundAdmin();
        }

        $pagination = new Pagination($users, $currentPage, $LineNumber);
        $pageNumber = $pagination->countPage();

        $arrayPage = $pagination->arrayPage($currentPage);

        $limit = $pagination->getLimit();
        $skip = ($currentPage - 1) * $LineNumber;

        $checked = 1;
        $posttable = $this->postRepository->listPostsByValidByLimit($limit, $skip);
        if (Input::exists()) {
            if (Input::get('radio') === 'option1') {
                // Default, By Date
                $posttable = $this->postRepository->listPostsByValidByLimit($limit, $skip);
                $checked = 1;
            } elseif (Input::get('radio') === 'option2') {
                // By User
                $posttable = $this->postRepository->listPostsByUsernameByLimit($limit, $skip);
                $checked = 2;
            } elseif (Input::get('radio') === 'option3') {
                // By User
                $posttable = $this->postRepository->listPostsByLimit($limit, $skip);
                $checked = 3;
            }
        }

        $link = 'admin/articles';

        $response = $this->renderResponse(
            'admin/articles.html.twig',
            [
                'posts' => $posttable,
                'pagenumber' => $pageNumber,
                'currentpage' => $currentPage,
                'arraypage' => $arrayPage,
                'option' => $checked,
                'link' => $link
            ]
        );

        return $response;
    }

    /**
     * show new comments in table
     * @param  string $page
     */
    public function comments($page = '1')
    {
        $this->adminOnly();

        $currentPage = (int)$page;
        $LineNumber = 20;

        $users = $this->postRepository->listPostsByCommentsNotValid();

        if ($users === false) {
            $this->notFoundAdmin();
        }

        $pagination = new Pagination($users, $currentPage, $LineNumber);
        $pageNumber = $pagination->countPage();

        $arrayPage = $pagination->arrayPage($currentPage);

        $limit = $pagination->getLimit();
        $skip = ($currentPage - 1) * $LineNumber;

        $checked = 1;
        $posttable = $this->postRepository->listPostsByCommentsNotValidByLimit($limit, $skip);

        $link = 'admin/comments';

        $response = $this->renderResponse(
            'admin/comments.html.twig',
            [
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
     * Show One Article identified by $id (title, contents, comments)
     * @param  int $id : id of the article
     */
    public function show($id = '')
    {
        $this->adminOnly();

        $onePost = $this->postRepository->findById($id);
        $comments = $this->commentRepository->listComments($id);

        if ($onePost === false || $comments === false) {
            $this->notFoundAdmin();
        }

        $response = $this->renderResponse(
            'admin/onearticle.html.twig',
            [
                'post' => $onePost,
                'comments' => $comments
            ]
        );

        return $response;
    }

    /**
     * Modify/update One Article identified by $id (title, contents, comments)
     */
    public function modify($id = '')
    {
        $this->adminOnly();

        $post = $this->postRepository->findById($id);

        if ($post === false) {
            $this->notFoundAdmin();
        }

        $profil = new PostValidator();
        $token = $profil->checkToken();
        $errors = $profil->csrfInput('validateUpdateFormPostAdmin', $id);

        if (!$errors) {
            $errors = [];
        }

        $response = $this->renderResponse(
            'admin/updatepost.html.twig',
            [
                'token' => $token,
                'post' => $post,
                'error' => $errors
            ]
        );

        return $response;
    }
}
