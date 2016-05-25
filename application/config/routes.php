<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

include('application/config/pdo_db_connect.php');
class dynamic_route{
	public $pdo_db = FALSE;
	public function __construct(){
    }
	
	public function create_title($string){
		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
		$string = str_replace($d, '', $string);
		$string = str_replace(' ', '-', $string);
		$string = str_replace('--', '-', $string);
		return strtolower($string);
	}
	
	private function query_routes($query){
		try{
			$routes_query = $this->pdo_db->query($query);
            if($routes_query){
                $return_data = array(); 
                foreach($routes_query as $row) {
                    $return_data[] = $row; 
                }
                return $return_data;

            }

            }catch(PDOException $e) {
                echo 'Please contact Admin: '.$e->getMessage();
            }

        }
    private function filter_route_data($data){

		$r_data = array();
        foreach($data as $row){
			$return_data = new stdClass;

            if(empty($row['Url_Variable']) ){
				$return_data->url = $row['Url'];
            }else{
				$return_data->url = $row['Url'].'/'.$row['Url_Variable'];
            }

            if(empty($row['Method']) && empty($row['Variable']) ){
				$return_data->route = $row['Class'];
            }elseif(!empty($row['Method']) && empty($row['Variable']) ){
				$return_data->route = $row['Class'].'/'.$row['Method'];
            }elseif(!empty($row['Method']) && !empty($row['Variable']) ){
				$return_data->route = $row['Class'].'/'.$row['Method'].'/'.$row['Variable'];
			}

            $r_data[] = $return_data;
        }
        return $r_data;
    }
    
	public function get_routes(){
		$route_data = $this->query_routes('SELECT * FROM tbl_kategori ORDER BY `name_kategori` ASC');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }

	public function barang_dijual(){
		$route_data = $this->query_routes('SELECT * FROM tbl_barang ORDER BY id desc');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    } 
	
	public function ensiklopedia_kategori(){
		$route_data = $this->query_routes('SELECT tbl_kategori.* FROM tbl_kategori WHERE tbl_kategori.ensiklopedia = 1 GROUP BY id');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }
	
	public function event(){
		$today = date('Y-m-d');
		//$route_data = $this->query_routes("SELECT * FROM tbl_event WHERE (end_date = '0000-00-00' || '".$today."' <= end_date) ORDER BY id DESC");
		$route_data = $this->query_routes("SELECT * FROM tbl_event ORDER BY id DESC");
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }
	
	public function turnamen(){
		$today = date('Y-m-d');
		$route_data = $this->query_routes("SELECT * FROM tbl_turnamen WHERE (end_date = '0000-00-00' || '".$today."' <= end_date) ORDER BY id DESC");
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }
	
	public function ensiklopedia(){
		$route_data = $this->query_routes('select * from tbl_divisi');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    } 
	
	public function detail_merchant(){
		$route_data = $this->query_routes('SELECT * FROM tbl_market_user where role_id = 2');
        return $route_data;
    }	
	
	public function get_item(){
		$route_data = $this->query_routes('SELECT tbl_market_item.id, tbl_market_user.name_merchant, tbl_market_user.first_name, tbl_market_user.last_name, tbl_market_item.name FROM tbl_market_item join tbl_market_user on tbl_market_user.id = tbl_market_item.merchant_id');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }
	
	public function get_pre_order(){
		$route_data = $this->query_routes('SELECT tbl_barang.name_barang, tbl_pre_order.id FROM tbl_pre_order join tbl_barang on tbl_barang.id = tbl_pre_order.id_barang');
        //$return_data = $this->filter_route_data($route_data);
        return $route_data;
    }
}

    $dynamic_route = new dynamic_route;
    // Give dynamic route database connection
    $dynamic_route->pdo_db = pdo_connect();
    // Get the route data
    $route_data = $dynamic_route->get_routes();
	//Iterate over the routes
    foreach($route_data as $row){
        $route[$dynamic_route->create_title($row["name_kategori"])] = "bursa/detail/".$row["id"]."/".$row["divisi_id"];
    }
	foreach($route_data as $row){
        $route['pre-order-'.$dynamic_route->create_title($row["name_kategori"])] = "bursa/detail_pre_order/".$row["id"]."/".$row["divisi_id"];
    }
	$route_data = $dynamic_route->barang_dijual();
	foreach($route_data as $row){
        $route[$dynamic_route->create_title($row["name_barang"])] = "ensiklopedia/show/".$row["id"];
    }
	$route_data = $dynamic_route->ensiklopedia_kategori();
	foreach($route_data as $row){
        $route["ensiklopedia-".$dynamic_route->create_title($row["name_kategori"])] = "ensiklopedia/detail_ensiklopedia/".$row["id"];
		$route["ensiklopedia-".$dynamic_route->create_title($row["name_kategori"])."/(:num)"] = "ensiklopedia/detail_ensiklopedia/".$row["id"]."/$1";
    }	
	$route_data = $dynamic_route->event();
	foreach($route_data as $row){
        $route["event-".$dynamic_route->create_title($row["title"])] = "event/detail/".$row["id"];
    }
	
	$route_data = $dynamic_route->turnamen();
	foreach($route_data as $row){
        $route["turnamen-".$dynamic_route->create_title($row["title"])] = "turnamen/detail/".$row["id"];
    }
	
	$route_data = $dynamic_route->ensiklopedia();
	foreach($route_data as $row){
		$route['ready-stock-all-'.$dynamic_route->create_title($row["name_divisi"])] = "bursa/bursa_all/".$row["id"];
		$route['ready-stock-all-'.$dynamic_route->create_title($row["name_divisi"]).'/(:num)'] = "bursa/bursa_all/".$row["id"]."/$1";
		$route['preorder-all-'.$dynamic_route->create_title($row["name_divisi"])] = "bursa/preorder_all/".$row["id"];
		$route['preorder-all-'.$dynamic_route->create_title($row["name_divisi"]).'/(:num)'] = "bursa/preorder_all/".$row["id"]."/$1";
        $route[$dynamic_route->create_title($row["name_divisi"])."-pedia"] = "ensiklopedia/index/".$row["id"];
		$route[$dynamic_route->create_title($row["name_divisi"])."-pedia-search"] = "ensiklopedia/ensiklopedia_search/".$row["id"];
		$route[$dynamic_route->create_title($row["name_divisi"])."-pedia-search/(:num)"] = "ensiklopedia/ensiklopedia_search/".$row["id"]."/$1";
    }
	
	$route_data = $dynamic_route->detail_merchant();
	foreach($route_data as $row){
		if(empty($row["name_merchant"])){
			$route["detail-merchant/".$dynamic_route->create_title(trim($row["first_name"]." ".$row["last_name"]))] = "detail_merchant/index/".$row["id"];
			$route["detail-merchant/".$dynamic_route->create_title(trim($row["first_name"]." ".$row["last_name"])).'/profile'] = "detail_merchant/profile/".$row["id"];
			$route["detail-merchant/".$dynamic_route->create_title(trim($row["first_name"]." ".$row["last_name"])).'/testimoni'] = "detail_merchant/testimoni/".$row["id"];
		}else{
			$route["detail-merchant/".$dynamic_route->create_title($row["name_merchant"])] = "detail_merchant/index/".$row["id"];
			$route["detail-merchant/".$dynamic_route->create_title($row["name_merchant"]).'/profile'] = "detail_merchant/profile/".$row["id"];
			$route["detail-merchant/".$dynamic_route->create_title($row["name_merchant"]).'/testimoni'] = "detail_merchant/testimoni/".$row["id"];
		}	
	}
	
	$route_data = $dynamic_route->get_item();
	foreach($route_data as $row){
		if(empty($row["name_merchant"])){
			$route["detail-merchant/".$dynamic_route->create_title(trim($row["first_name"]." ".$row["last_name"]))."/detail-item/".$row['id']."/".$dynamic_route->create_title($row['name'])] = "detail_merchant/show/".$row["id"];
		}else{
			$route["detail-merchant/".$dynamic_route->create_title($row["name_merchant"])."/detail-item/".$row['id']."/".$dynamic_route->create_title($row['name'])] = "detail_merchant/show/".$row["id"];
		}
		
	}
	
	$route_data = $dynamic_route->get_pre_order();
	foreach($route_data as $row){
		$route["pre-order/detail-item/".$dynamic_route->create_title($row["name_barang"])] = "pre_order/detail_pre_order/".$row["id"];		
	}
	
	
	
	

$route['default_controller'] = "page";
$route['404_override'] = 'page/error_404';
//general
$route['hubungi-kami'] = "page/hubungi_kami";
$route['how-to-buy'] = "page/how_to_buy";
$route['FAQ'] = "page/faq";
$route['cara-pasang-event-turnamen'] = "page/cara_pasang_event_turnamen";
$route['artikel-(:any)'] = "artikel/show/$1";
$route['list-event'] = "event/index";
$route['daftar-event'] = "event/daftar_event";
$route['event-for-check'] = "roomuser/show_event_validation";

$route['save-daftar-event'] = "event/save_daftar_event";
$route['list-event/(:num)'] = "event/index/$1";
$route['list-toko'] = "page/list_toko";
$route['daftar-toko'] = "page/daftar_toko";
$route['list-komunitas'] = "page/list_komunitas";
$route['daftar-komunitas'] = "page/daftar_komunitas";
$route['kirim-pesan'] = "page/send_email_to_us";
//ensiklopedia
$route['pictures-(:any)'] = "pictures/index/$1";
//bursa
//$route['ready-stock-all'] = "bursa/bursa_all";
//$route['ready-stock-all/(:num)'] = "bursa/bursa_all/$1";
//$route['preorder-all'] = "bursa/preorder_all/$1";
//$route['preorder-all/(:num)'] = "bursa/preorder_all/$1";
//user
//$route['confirmation-email/(:any)'] = "page/confirmation_email/$1";
$route['confirmation_email/(:any)'] = 'signup/confirmation_email/$1';
//semua yang berhubungan dengan proses order sampai customer memberitahu kalau barang sudah dapat;
$route['order-list'] = "roomuser/order_list";
$route['add-to-cart'] = "roomuser/add_to_cart";
$route['order-form'] = "roomuser/order_form";
$route['clear-order'] = "roomuser/clear_order";
$route['delete-one-item'] = "roomuser/delete_one_item";
$route['send-order'] = "roomuser/save_order";
$route['view-order/(:any)'] = 'roomuser/view_order/$1';
$route['invoice-form/(:any)'] = 'roomuser/invoice_form/$1';
$route['invoice-calculate'] = 'roomuser/invoice_calculate';
$route['submit-invoice'] = 'roomuser/invoice_submit';
$route['view-invoice/(:any)'] = 'roomuser/invoice_view/$1';
$route['report-your-payment'] = 'roomuser/create_payment_report';
$route['payment-list'] = 'roomuser/payment_list';
$route['send-report-payment'] = 'roomuser/save_payment_report';
$route['view-payment/(:any)'] = 'roomuser/payment_view/$1';
$route['confirm-report-payment'] = 'roomuser/confirm_report_payment';
$route['save-shipment'] = 'roomuser/save_shipment';
$route['get-item'] = 'roomuser/get_item';
//market
$route['profile'] = 'roomuser/index';
$route['change_password'] = 'roomuser/change_password';
$route['process_change_password'] = 'roomuser/process_change_password';
$route['change_profile'] = 'roomuser/change_profile';
$route['process_change_profile'] = 'roomuser/process_change_profile';
//$route['signup-seller'] = 'signup/signup_seller';
$route['list-seller'] = 'market/list_seller';
$route['market-help'] = 'market/help';
$route['how-to-buy'] = 'market/how_to_buy';
$route['how-to-sell'] = 'market/how_to_sell';
$route['rule-for-buyer'] = 'market/rule_for_buyer';
$route['how-to-be-seller'] = 'market/how_to_be_seller';
$route['order-form'] = 'roomuser/order_form';
$route['list-order'] = 'roomuser/order_list';
$route['account-bank'] = 'roomuser/account_bank_form';
$route['status-payment/(:any)'] = 'roomuser/status_payment/$1';
$route['ensiklopedia-terkait'] = 'roomuser/ensiklopedia_terkait';
$route['add-link-ensiklopedia/(:any)'] = 'roomuser/add_link_ensiklopedia/$1';
$route['delete-link-ensiklopedia'] = 'roomuser/delete_link_ensiklopedia';
$route['pre-order'] = 'pre_order/show_pre_order';

//market roomuser untuk seller
$route['list-item'] = 'roomuser/item_list';
$route['edit-item/(:any)'] = 'roomuser/edit_item_form/$1';
$route['item-form'] = 'roomuser/item_form';
$route['show-item/(:any)'] = 'roomuser/item_show/$1';

//forget password
$route['forget-password'] = 'signup/forget_password';
$route['confirmation-forget-password/(:any)'] = 'signup/confirmation_reset_password/$1';
$route['send-reset-password'] = 'signup/process_reset_password';
/* End of file routes.php */
/* Location: ./application/config/routes.php */