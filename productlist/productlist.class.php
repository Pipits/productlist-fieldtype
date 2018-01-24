<?php
/**
 * A field type for selecting products from the official Perch Shop app.
 * 
 * @author Hussein Al Hammad
 * 
 */
class PerchFieldType_productlist extends PerchAPI_FieldType
{
    public function render_inputs($details=array())
    {
        $id  = $this->Tag->input_id();
        $val = '';
        
        if (isset($details[$id]) && $details[$id]!='') 
        {
            $val = $this->Form->get($details, $this->Tag->id(), $this->Tag->default(), $this->Tag->post_prefix()); 
        }
        
        $ShopAPI    = new PerchAPI(1, 'perch_shop');
	    $Products   = new PerchShop_Products($ShopAPI);
        $products = $Products->all();

        $opts   = array();
        $opts[] = array('label'=>'', 'value'=>'');

        if (PerchUtil::count($products))
        {
            foreach($products as $Product)
            {
                $opts[] = array('label'=>$Product->title(), 'value'=>$Product->productSlug());
            }
        }

        
        
        $classes= 'input-simple categories m selectized';
        $attributes = ' data-display-as="categories"';
        
        if ($this->Tag->max()) 
        {
			$attributes .= ' data-max="'.(int)$this->Tag->max().'"';
        }
        
        if ($this->Tag->placeholder()) 
        {
            $attributes .= ' placeholder="'.$this->Tag->placeholder().'"';
        }
        else
        {
            $attributes .= ' placeholder=" "';
        }
        
        $attributes = trim($attributes);

        
        
        if (PerchUtil::count($opts)) 
        {
        	$s = $this->Form->select($id, $opts, $val, $classes, true, $attributes);
        } 
        else 
        {
        	$s = '-';
        }
        

        return $s;
    }
       
    public function get_raw($post=false, $Item=false) 
    {
        $store  = array();
        $id     = $this->Tag->id();

        if ($post===false)
        {
            $post = $_POST;
        }
        
        if (isset($post[$id])) 
        {
            $this->raw_item = $post[$id];
            $products = $this->raw_item;

            foreach($products as $productSlug)
            {
                $store[] = $productSlug;
            }
        }

        return $store;
    }
    
    public function get_processed($raw=false)
    {    
        if ($raw===false)
        {
            $raw = $this->get_raw();
        }
        
        $value = $raw;

        if (is_array($value)) 
        {
            return implode(',', $value);
        }
        
        return $value;
    }
    
    public function get_search_text($raw=false)
    {
		return false;
    }
}