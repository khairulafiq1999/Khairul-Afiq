<?php
use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace
//include productsProc.php file
include __DIR__ . '/../function/productProc.php';
//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){
 return $this->response->withJson(array('data' => 'success'), 200);
});
//request table products by condition
$app->get('/products/[{price}]', function ($request, $response, $args){

 $productprice = $args['price'];
 if (!is_numeric($productprice)) {
 return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
 $data = getProduct($this->db,$productprice);
 if (empty($data)) {
 return $this->response->withJson(array('error' => 'no data'), 404);
}
 return $this->response->withJson(array('data' => $data), 200);
});

//insert data by price 
$app->post('/insertProduct', function(Request $request, Response $response,array $arg){  

    $form_data=$request->getParsedBody();
    $data = createProduct($this->db, $form_data);
  
    if (is_null($data)) {
      return $this->response->withJson(array('error' => 'no data'), 404);
    }
    
  
  return $this->response->withJson(array('data' => 'successfully added'), 200);
    
  
  });

//delete row by price
$app->delete('/products/del/[{price}]', function ($request, $response, $args){
    
  $productprice = $args['price'];
 if (!is_numeric($productprice)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
$data = deleteProduct($this->db,$productprice);
if (empty($data)) {
 return $this->response->withJson(array($productprice=> 'is successfully deleted'), 202);};
});


//put table products
$app->put('/products/put/[{price}]', function ($request,  $response,  $args){
  $productprice = $args['price'];
  $date = date("Y-m-j h:i:s");
  
 if (!is_numeric($productprice)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
  $form_dat=$request->getParsedBody();
  
$data=updateProduct($this->db,$form_dat,$productprice,$date);

return $this->response->withJson(array('data' => $data), 200);

});
