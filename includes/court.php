<?php
class Court
{
    // Represents a club

	public $court_unique_id;
	public $court_club_id;
	public $club_id;
	public $type;
	public $surface;

    public function __construct() {
      $this->court_unique_id=NULL;
      $this->court_club_id=NULL;
      $this->club_id=NULL;
      $this->type=NULL;
      $this->surface=NULL;
    }


}
?>