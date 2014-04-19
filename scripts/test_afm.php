<?php
require_once('../app/Mage.php');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$c = Mage::getModel("afm/category");
$p = Mage::getModel("afm/product");
// 
// //$p->description = "nuova descrizione" ;
// 
//$p->createSimple("TEST_INS44");
// 
// // $mio_id = $p->getIdByAttributeValue("codice_ean",123456) ;
// // if (!$mio_id){
// // 	echo "inserisco nuovo prodotto" ;
// // }else{
// //  $p->loadById($mio_id) ;
// // }
// $p->loadById(176) ;
// $p->addTierPrice(5,12) ;
//$p->loadBySku("TEST_INS44") ;
// // $p->sku =  "TEST_NEW";
//$p->sku = "cambiosku" ;
//$p->name = "Che bello" ;
//  $p->setAttributeOptionValue("fornitore","Markino") ;
//  $p->setAttributeOptionValueMulti("tipo_gomma",array("neve","estiva")) ;
// //  $p->setStock(0);
// //$p->removeAllCategoryIds() ;
// // $p->setCategoryIds(array(4,5)) ;
// // $p->removeProductImages() ;
// $p->addImageToMediaGallery("/prova/om1.jpg", array('small_image'),  $exclude=false) ;
// $p->addImageToMediaGallery("/prova/om2.jpg", array('thumbnail'),  $exclude=false) ;
// $p->addImageToMediaGallery("/prova/om3.jpg", array('image'),  $exclude=false) ;
//$p->names = "descrizione di prova" ;
//echo $p->sku . " " . $p->description . " " . $p->getId() . "\n" ;
$c->loadById(32)  ;

echo $c->name . " " . $c->description . " " . $c->display_mode . "\n" ;
//echo $p->sku . " " . $p->attribute_set_id ."\n" ;
//echo $c->entity_id . " " . $c->getCategoryPathNames() . "\n" ;
//echo $c->getCategoryPathIds() . "\n" ;
//echo $c->getCategoryIdFromPathNames($c->getCategoryPathNames()) . "\n";

//$c->createEntity($parent_id =8, $attribute_set_id ='12') ;
//$c->name = "deskjet" ;
//$c->is_active = 1 ;	 
//$c->include_in_menu = 1 ; 		
//$c->display_mode = "PRODUCTS_AND_PAGE" ;
//$c->is_anchor = 0 ;
//$c->loadById(1) ;
//$c->name = "master"  ;
//echo $path = $c->name . "/laser" ;
//echo $path = "laserd" ;
//echo "\n" ;
//echo "Id root: " . var_dump($c->getCategoryIdFromPathNames($path)) . "\n";

//$stack = array("orange", "banana", "apple", "raspberry");
//$fruit = array_pop($stack);
//echo $fruit . "\n" ;
//echo print_r($stack) ."\n";
//echo implode('/',array('ciao')) . "\n";
//echo print_r(explode('/','ciao')) . "\n";

//$p = new Category() ;
//$c->loadById(19) ;
//$c->children_count = 16 ;
//$c->position = 15 ;
//$c->name = "provaaaaa dddddd" ;
//echo "posizione " . ()  . "\n";  
//echo "children_count " . () . "\n" ;

//echo $c->create("Root store2/diffusori/a colonna") . "\n" ; 
//echo $c->create("Root store2/cellulari/gsm") . "\n" ; 
//echo $c->create("Root store2/cellulari/gsm") . "\n" ; 
//echo $c->getCategoryIdFromPathNames("/laser") ;
//$c->create("stampati/laser/bn") ;





