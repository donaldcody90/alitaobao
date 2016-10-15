<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model
{

     private $table_orders = 'orders';
     private $table_order_note = 'order_note';
     private $table_customers = 'customers';
     private $table_items = 'items';
     private $table_sellers = 'sellers';
     private $table_ships = 'ships';
     private $table_complain = 'complain';
     private $table_seller_note = 'seller_note';
     private $table_settings = 'settings';
     private $table_invoice_ships = 'invoice_ships';
     private $table_history_order_status = 'history_order_status';
     private $table_ship_only = 'ship_only';

     function __construct()
     {
          parent::__construct();
     }

     // Lấy danh sách đơn hàng về muộn
     function getOrderDelay(){
          $query = $this->db->select ($this->table_ships.'.*,'.$this->table_orders.'.*');
          $query = $this->db->from($this->table_ships);
          $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_ships.'.oid');
          $query = $this->db->where( 'ships.created_date <=', date('Y-m-d',strtotime('-6 day') ));
          $query = $this->db->order_by($this->table_ships.'.id', 'desc'); 
          $query = $this->db->get();
          $list = $query->result_array();
          return $list;
     }

     // Lấy danh ghi chu cua don hang

     function getNoteOrder($oid){
          $query = $this->db->select ('*');
          $query = $this->db->from($this->table_order_note);
          $query = $this->db->where('oid',$oid);
          $query = $this->db->get();
          $list = $query->result_array();
          return $list;
     }
     function get_note_by_Seller($sid)
     {
      $this->db->select ( '*' );
      $this->db->from($this->table_seller_note);
      $this->db->where(array('sid'=>$sid));
      $query = $this->db->get();
      return $query->result_array();
     }
     function getHistoryOrderStatus($oid)
     {
      $this->db->select ( '*' );
      $this->db->from($this->table_history_order_status);
      $this->db->where(array('oid'=>$oid,'status'=>3));
      $query = $this->db->get();
      return $query->result_array();
     }

    /*
    Function findOrder
    param_where = array(fieldName=>fieldValue)
    */
     function findOrder($params_where,$is_list=false){
        $result = $this->_getwhere(array(
                      'table'        => $this->table_orders,
                      'param_where'  => $params_where,
                      'list'         => $is_list
          ));
        return $result;
     }
   /*
    Lấy ra những đơn hàng mà tát cả các vận đơn đã được check
   */
   function getOrderCheckAll(){
      $query = $this->db->query("SELECT * from orders where id in (SELECT oid FROM ships GROUP BY oid HAVING SUM(is_check) >= COUNT(id)  AND SUM(is_delivered) < COUNT(id)) AND status in (3,4)");
      return $query->result_array();
    }
   /*
    lấy danh sách sản phẩm trong một đơn hàng hoặc người bán
   */
   function getItems($oid,$sid=0)
   {
    $this->db->select ( '*' );
    $this->db->from($this->table_items);
    $this->db->where(array('oid'=>$oid));
    if($sid){
      $this->db->where(array('sid'=>$sid)); 
    }
    $query = $this->db->get();
    $res = $query->result_array();
    return $res;
   }
   /*
    lấy danh sách người bán trong 1 đơn hàng
   */
   function getSellers($oid)
   {
    $this->db->select ( '*' );
    $this->db->from($this->table_sellers);
    $this->db->where(array('oid'=>$oid));
    $query = $this->db->get();
    $sellers =  $query->result_array();
    return $sellers;
   }
   
   function getItemSeller($order,$seller){
      $item_by_seller=$this->getItems($order['id'],$seller['id']);
      $res=array(
        'items'=>$item_by_seller,
        'order_seller_summary'=>$this->get_Order_Seller_Summary($order,$item_by_seller,array($seller)),
        'ships'=> $this->getShips($seller['oid'],$seller['id']),
        'note_by_seller'=> $this->get_note_by_Seller($seller['id']),
      );
      return $res;
   }

  /*
    Lấy thông tin vận đơn của người bán
  */
    function getShips($oid,$sid=''){
          $this->db->select ( '*' );
          $this->db->from( $this->table_ships );
          $this->db->where( array('oid'=>$oid,'sid'=>$sid));
          $query = $this->db->get();
          return $query->result_array();
     }

  /*
    Lấy thông tin vận đơn đã được duyêt hay chưa???
  */
    function getShips_check($oid,$param=true){
          $this->db->select ( '*' );
          $this->db->from( $this->table_ships );
          //Nếu param = false, lấy ra những vận đơn chưa được check
          if( $param==true ){
            $this->db->where( array('oid'=>$oid) );
          }else{
            $this->db->where( array('oid'=>$oid,'is_delivered'=>0) );
          }
          
          $query = $this->db->get();
          return $query->result_array();
     }

  /*
    Lấy chi tiết đơn hàng theo từng người bán
  */
     function getDetailOrderSeller($order,$sellers){
         if( count($sellers )){
               foreach ($sellers as $key => $seller) {
                 $sellers[$key]=array_merge($sellers[$key],$this->getItemSeller($order,$seller));
               }
          }
    return $sellers;
     }
   
     function getDetailOrder($invoiceid=''){
          $query = $this->db->select ('orders.*,customers.*');
          $query = $this->db->from($this->table_orders);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->where( array('orders.invoiceid'=>$invoiceid));
          $query = $this->db->get();
          $order=$query->row_array();
          if($order)
          {
              $items=$this->getItems($order['id']);
              $sellers=$this->getSellers($order['id']);
              $order['order_summary']=$this->get_Order_Seller_Summary($order,$items,$sellers);
              $order['detail']=$this->getDetailOrderSeller($order,$sellers);
          }
          return $order;
     }

	 function getDetailOrderShipOny($invoiceid=''){
		  $query = $this->db->select ('orders.*,customers.*');
          $query = $this->db->from($this->table_orders);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->where( array('orders.invoiceid'=>$invoiceid));
          $query = $this->db->get();
          $order=$query->row_array();
		  if($order)
          {

              $order['listShip']=$this->getShipOrderOnlyShip($order['id']);
			  
          }
          return $order;
	 }
	 // Get list ship for order onlyship
	 function getShipOrderOnlyShip($oid){
		  $query = $this->db->select ('*');
          $query = $this->db->from($this->table_ship_only);
          $query = $this->db->where( array('order_id'=>$oid));
          $query = $this->db->get();
		  return $query->result_array();
	 }

     function updateOrder($data,$params_where){
           $result = $this->_save(array(
                                        'table'        => $this->table_orders,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $result;
     }

     function insertNoteOrder($data){
           $result = $this->_save(array(
                                        'table'        => $this->table_order_note,
                                        'data'         => $data,
                                   ));
          return $result;
     }

     function insert_history_order_status($data){
           $result = $this->_save(array(
                                        'table'        => $this->table_history_order_status,
                                        'data'         => $data,
                                   ));
          return $result;
     }
     function insertSeller_note($data){
          return $this->_save(array(
               'table' => $this->table_seller_note,
               'data' => $data
          ));
     }

     function insertShip($data){
          return $this->_save(array(
               'table' => $this->table_ships,
               'data' => $data
          ));
     }

     function insertComplain($data){
          return $this->_save(array(
               'table' => $this->table_complain,
               'data' => $data
          ));
     }

     function updateShopid($data,$params_where){
          return $this->_save(array(
               'table' => $this->table_sellers,
               'data' => $data,
               'param_where'  => $params_where
          ));
     }


     function updateShipid($data,$params_where){
          return $this->_save(array(
               'table' => $this->table_ships,
               'data' => $data,
               'param_where'  => $params_where
          ));
     }

     function updateFreeship_nd($data,$params_where){
          return $this->_save(array(
               'table' => $this->table_sellers,
               'data' => $data,
               'param_where'  => $params_where
          ));
     }

     function updateSeller($data,$params_where){
           $result = $this->_save(array(
                                        'table'        => $this->table_sellers,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $result;
     }

     function updateItem($data,$params_where){
           $result = $this->_save(array(
                                        'table'        => $this->table_items,
                                        'data'         => $data,
                                        'param_where'  => $params_where
                                   ));
          return $result;
     }
	 function deleteItem($params_where){
           $result = $this->_del(array(
                                        'table'        => $this->table_items,

                                        'param_where'  => $params_where
                                   ));
     }
	 function deleteSellerInOrder($params_where){
           $result = $this->_del(array(
							'table' => $this->table_sellers,
                            'param_where'  => $params_where
                          ));
     }

     function deleteOrder($params_where){
          return $this->_del(array(
               'table'        => $this->table_orders,
               'param_where'  => $params_where
          ));
     }

     function deleteShip($params_where){
          return $this->_del(array(
               'table'        => $this->table_ships,
               'param_where'  => $params_where
          ));
     }
   /*
    Tính tổng số lượng, tổng tiền dịch vụ, tiền thực mua, và tổng tiền 
    cho 1 đơn hàng hoặc theo người bán, phụ thuộc vào Items
   */
     function get_Order_Seller_Summary($order,$items,$sellers = array())
     {
          $res=array(
                'total_quantity'=>0,
                'total_price'=>0,
                'total_real_price'=>0,
                'total_fee_service'=>0,
                'total_fee_shipnd'=>0,
                'currency_rate'=>$order['currency_rate'],
                'fee_service_percent'=>$order['fee_service_percent'],
               );
       if(count($items))
       {
           foreach($items as $item){
            
            $item_real_price=( $item['item_price']*$item['item_quantity'] );
            $item_fee_service=(( $item['item_price'] * ($order['fee_service_percent']/100)) * $item['item_quantity'] );
            $res['total_quantity'] +=$item['item_quantity'];
            $res['total_real_price'] += $item_real_price;
            $res['total_fee_service'] += $item_fee_service;
            $res['total_price'] += ( $item_real_price + $item_fee_service);
          
           }
       }
       if(count($sellers))
       {
         foreach($sellers as $seller)
         {
          $res['total_fee_shipnd'] +=$seller['fee_shipnd'];
         }
		  $res['total_price']= $res['total_price'] + $res['total_fee_shipnd'];
       }
       return $res;
     }


     function getDetailDelivery($oid){
          $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.*');
          $query = $this->db->from($this->table_orders);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->where($this->table_orders.'.id',$oid);
          $query = $this->db->get();
          $list = $query->row_array();
          //echo $list['id'];die;
          if( $list ){
            $list['delivery'] = $this->getShips_check($list['id']);
          }
          return $list;
     }

     function getDelivery($filter=array(),$total=0,$start=0){
          if( count( $filter ) >0 ){
            vst_buildFilter($filter);
            $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.*');
            $query = $this->db->from($this->table_orders);
            $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
            $query = $this->db->limit($total, $start);
            $query = $this->db->get();
            $list = $query->result_array();
            if( $list ){
              foreach ($list as $key => $value) {
                $list[$key]['delivery'] = $this->getShips_check($value['id'],$param=false);
              }

            }
            // echo "<pre>";
            // print_r($list);die;
            return $list;
          }
     }

     //Lấy ra danh sách vận đơn đã được kiêm duyệt
     function listDelivery($delay=false,$param=''){
          $query = $this->db->select ($this->table_ships.'.*,'.$this->table_orders.'.create_date,'.$this->table_orders.'.invoiceid,'.$this->table_orders.'.store,'.$this->table_customers.'.username,'.$this->table_customers.'.address,'.$this->table_customers.'.fullname,'.$this->table_customers.'.phone,'.$this->table_customers.'.cid');
          $query = $this->db->from($this->table_ships);
          $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_ships.'.oid');
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->where( array($this->table_ships.'.is_check'=> 1,$this->table_ships.'.is_delivered'=> 0) );
          if( $delay==true ){
             $query = $this->db->where('ships.created_date <=', date('Y-m-d',strtotime('-'.$param.' day')) );
          }
          $query = $this->db->order_by($this->table_ships.'.id', 'desc'); 
          $query = $this->db->get();
          $list = $query->result_array();
          return $list;
     }

    function totalDelivery($filter){
          vst_buildFilter($filter);
          $query = $this->db->select ($this->table_ships.'.*,'.$this->table_orders.'.invoiceid,'.$this->table_orders.'.store,'.$this->table_customers.'.username,'.$this->table_customers.'.address,'.$this->table_customers.'.fullname,'.$this->table_customers.'.phone,'.$this->table_customers.'.cid');
          $query = $this->db->from($this->table_ships);
          $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_ships.'.oid');
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->where($this->table_ships.'.is_check',1);
          $query = $this->db->get();
          return $query->num_rows();
    }

     function listOrder($filter=array(),$total=0,$start=0){
          vst_buildFilter($filter);
          $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.username,'.$this->table_customers.'.address,'.$this->table_customers.'.fullname,'.$this->table_customers.'.phone,'.$this->table_customers.'.email');
          $query = $this->db->from($this->table_orders);
          $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
          $query = $this->db->order_by($this->table_orders.'.id', 'desc'); 
          
          $query = $this->db->limit($total, $start);
          $query = $this->db->get();

          $records = $query->num_rows();
          $list = $query->result_array();
          if($list)
          {
               foreach($list as $key=>$order){
                 $items=$this->getItems($order['id']);
                 $sellers=$this->getSellers($order['id']);
                 $list[$key]['order_summary']=$this->get_Order_Seller_Summary($order,$items,$sellers);
               }
          }

          $results = array( 'list'=> $list,'records'=> $records );
          return $results;
     }

    function totalOrder($filter){
        vst_buildFilter($filter);
        $query = $this->db->select ($this->table_orders.'.*,'.$this->table_customers.'.*');
        $query = $this->db->from($this->table_orders);
        $query = $this->db->join ($this->table_customers, $this->table_customers.'.cid = '.$this->table_orders.'.cid');
        $query = $this->db->get();
    return $query->num_rows();
    }


    function getOrderStatusSummury($filter){
      vst_buildFilter($filter);
      $order_status_sum=$this->config->item('site')['order_status'];
      $this->db->select ('status, COUNT(*) as total_orders');
      $this->db->from ($this->table_orders);
      $this->db->group_by('status');
      $query = $this->db->get();
      $results=$query->result_array();
      $total_orders=0;
      if($results)
      { 
        foreach($results as $item)
        {
          $order_status_sum[$item['status']]['count']=$item['total_orders'];
          $total_orders +=$item['total_orders'];
        }
      }
      $order_status_sum["-99"]['count']=$total_orders;
      return $order_status_sum;
    }

   function listShopNull($shopid=false,$free_shipnd=false){

    $query = $this->db->select ($this->table_sellers.'.*,'.$this->table_orders.'.store,'.$this->table_orders.'.status,'.$this->table_orders.'.invoiceid' );
    $query = $this->db->from($this->table_sellers);
    $query = $this->db->join ($this->table_orders, $this->table_orders.'.id = '.$this->table_sellers.'.oid');
    //Lấy những đơn hàng đã mua hàng  trở lên
    $query = $this->db->where ($this->table_orders.'.status >=',3 );
    if( $shopid==true ){
      $query = $this->db->where ($this->table_sellers.'.shopid', NULL);
    }elseif ($free_shipnd==true) {
      $query = $this->db->where ($this->table_sellers.'.fee_shipnd', 0);
    }
    $query = $this->db->order_by($this->table_sellers.'.id', 'desc'); 
    $query = $this->db->get();
    return  $query->result_array();
   }

   function listShipNull(){

    $query = $this->db->query("select s.*,o.invoiceid,o.store,o.status from sellers  as s inner join orders as o on s.oid=o.id where o.status >=3 and s.id not in (select sid from ships) order by s.oid");
    return  $query->result_array();
   }

}

?>