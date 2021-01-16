<?php 

namespace App\Useful_funcs;

class Pagination {

	private $amount;
	private $max_in_one_page;
	private $current_page;
	private $html;
	private $url_main;
	private $last_page;



	public function __construct($amount,$max_in_one_page,$current_page,$url_main){
		$this->amount = $amount;
		$this->max_in_one_page = $max_in_one_page;
		$this->current_page = $current_page;

		$this->url_main= $url_main."page-";

	}



	 public function get_pag(){

	 	$this->html.= "<div class='main_pagination'>";
		

		if($this->current_page!=1){
			$this->html.="<a class='left_pag' href='".$this->url_main.($this->current_page-1)."'>&laquo;</a>";
		}
		// else{
		// 	$this->html.="<span class='left_pag'>&laquo;</span>";
		// }

		$current_page = intval($this->current_page);

		$num_of_pages = $this->get_num_pages();

		for ($i=1; $i<=$num_of_pages; $i++) {

			if($i===$current_page){
				$this->html.="<a class='pag_pages current_page' href='".$this->url_main.$i."'>".$i."</a>";
			}
			else{
				$this->html.="<a class='pag_pages no_current_pages' href='".$this->url_main.$i."'>".$i."</a>";
			}
			
		}



		
		if($this->current_page<$this->last_page){
			$this->html.="<a class='right_pag' href='".$this->url_main.($this->current_page+1)."'>&raquo;</a>";
		}
		// else{
			// $this->html.="<span class='right_pag'>&raquo;</span>";
		// }
		$this->html.="</div>";


		return $this->html;
	}

	private function get_num_pages(){
		$amount = $this->amount;
		$max = $this->max_in_one_page;

		if($amount%$max)
			$num = intval(($amount/$max))+1;
		else
			$num = $amount/$max;
		
		$this->last_page = $num;
		return $num;
	}

}