<?php
class Club
{
    // Represents a club

	public $club_id;
	public $club_name;
	public $num_courts;
	public $open_time;
	public $close_time;
  public $block_size;

    public function __construct() {
      $this->club_id=NULL;
      $this->club_name=NULL;
      $this->num_courts=NULL;
      $this->open_time=NULL;
      $this->close_time=NULL;
      $this->block_size=NULL;
    }


}
?>