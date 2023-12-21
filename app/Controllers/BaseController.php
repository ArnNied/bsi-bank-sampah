<?php

namespace App\Controllers;

use App\Models\MAdmin;
use App\Models\MKategori;
use App\Models\MNasabah;
use App\Models\MPenarikan;
use App\Models\MSetoran;
use App\Models\MTeller;
use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected \CodeIgniter\Session\Session $session;
    protected BaseConnection $db;

    protected MAdmin $admin_model;
    protected MTeller $teller_model;
    protected MNasabah $nasabah_model;

    protected MKategori $kategori_model;
    protected MSetoran $setoran_model;
    protected MPenarikan $penarikan_model;

    protected ?string $user_role;
    protected $logged_in_user;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        ini_set('display_errors', 1);
        date_default_timezone_set('Asia/Jakarta');

        // Preload any models, libraries, etc, here.
        $this->admin_model = new \App\Models\MAdmin();
        $this->teller_model = new \App\Models\MTeller();
        $this->nasabah_model = new \App\Models\MNasabah();
        $this->kategori_model = new \App\Models\MKategori();
        $this->setoran_model = new \App\Models\MSetoran();
        $this->penarikan_model = new \App\Models\MPenarikan();

        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();

        $this->user_role = $this->session->get('role');
        $this->logged_in_user = $this->session->get('user');
    }
}
