<?php
    interface iTemplate
    {
        public function GetMenuTitle();
        public function GetPageTitle();
        public function GetPageId();
        public function GetTemplate();
    }
    
    abstract class abstractStats implements iTemplate
    {
        protected $menutitle = "";
        protected $pagetitle = "";
        protected $pageid = "";
        protected $template = "";
        
        abstract public function GetData();
        
        public function GetMenuTitle()
        {
            return $this -> menutitle;
        }
        
        public function GetPageTitle()
        {
            return $this -> pagetitle;
        }
        
        public function GetPageId()
        {
            return $this -> pageid;
        }
        
        public function GetTemplate()
        {
            return $this -> template;
        }
    }
?>