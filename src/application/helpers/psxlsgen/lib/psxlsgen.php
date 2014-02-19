<?php
/****************************************************************
* Script         : PHP Simple Excel File Generator - Base Class
* Project        : PHP SimpleXlsGen
* Author         : Erol Ozcan <eozcan@superonline.com>
* Version        : 0.3
* Copyright      : GNU LGPL
* URL            : http://psxlsgen.sourceforge.net
* Last modified  : 13 Jun 2001
* Description     : This class is used to generate very simple
*   MS Excel file (xls) via PHP.
*   The generated xls file can be obtained by web as a stream
*   file or can be written under $default_dir path. This package
*   is also included mysql, pgsql, oci8 database interaction to
*   generate xls files.
*   Limitations:
*    - Max character size of a text(label) cell is 255
*    ( due to MS Excel 5.0 Binary File Format definition )
*
* Credits        : This class is based on Christian Novak's small
*    Excel library functions.
******************************************************************/
 
if( !defined( "PHP_SIMPLE_XLS_GEN" ) ) {
    define( "PHP_SIMPLE_XLS_GEN", 1 );
 
    class  PhpSimpleXlsGen {
       private  $class_ver = "0.3";    // class version
       private  $xls_data   = "";      // where generated xls be stored
       private  $default_dir = "";     // default directory to be saved file
       private  $filename  = "psxlsgen";       // save filename
       private  $fname    = "";        // filename with full path
       private  $crow     = 0;         // current row number
       private  $ccol     = 0;         // current column number
       public  $totalcol = 0;         // total number of columns
       private  $get_type = 0;         // 0=stream, 1=file
       private  $errno    = 0;         // 0=no error
       private  $error    = "";        // error string
       private  $dirsep   = "/";       // directory separator
       private  $header   = 0;         // 0=no header, 1=header line for xls table
       private  $col_widths = array();
       private  $updateColWidth = true;
      // Default constructor
      function  PhpSimpleXlsGen()
      {
        $os = getenv( "OS" );
       $temp = getenv( "TEMP");
        // check OS and set proper values for some vars.
       if ( stristr( $os, "Windows" ) ) {
           $this->default_dir = $temp;
           $this->dirsep = "\\";
        } else {
          // assume that is Unix/Linux
          $this->default_dir = "/tmp";
          $this->dirsep =  "/";
        }
        // begin of the excel file header
        $this->xls_data = pack( "ssssss", 0x809, 0x08, 0x00,0x10, 0x0, 0x0 );
 
        // check header text
        if ( $this->header ) {
          $this->Header();
        }
      }
 
      function Header( $text="" ) {
         if ( $text == "" ) {
            $text = "This file was generated using PSXlsGen at ".date("D, d M Y H:i:s T");
         }
         if ( $this->totalcol < 1 ) {
           $this->totalcol = 1;
         }
         $this->InsertText( $text );
         $this->crow += 2;
         $this->ccol = 0;
      }
 
      // end of the excel file
      function End()
      {
   //       die();
         foreach($this->col_widths as $c=>$w) 
             $this->xls_data .= pack("sssssssC", 0x7D, 11,$c,$c,$w*256,0,0,0);
        $this->xls_data .= pack( "ss", 0x0A, 0x00 );
        return;
      }
 
      // write a Number (double) into row, col
      function WriteNumber_pos( $row, $col, $value )
      {
          if ($this->updateColWidth) {
              $len = strlen( $value );
              $this->updateColWidth($col,$len); 
         }
         $this->xls_data .= pack("sssss", 0x0203, 14, $row, $col, 0x01);
         $this->xls_data .= pack( "d", $value );
         return;
      }
 
 
      // write a label (text) into Row, Col
      function WriteText_pos( $row, $col, $value )
      {
          $len = strlen( $value );
          if ($this->updateColWidth) {
              $this->updateColWidth($col,$len); 
         }
         $this->xls_data .= pack( "s*", 0x0204, 8 + $len, $row, $col, 0x00, $len ); 
         $this->xls_data .= $value;
         return;
      }
      
      private function updateColWidth($col,$w){
		++$w; //propo le pone un poco mas de "aire" a la columna
         if(!isset($this->col_widths[$col]))
             $this->col_widths[$col] = 0;
         $this->col_widths[$col] = max($w,$this->col_widths[$col]);
      }
 
      // insert a number, increment row,col automatically
      function InsertNumber( $value )
      {
         if ( $this->ccol == $this->totalcol ) {
            $this->ccol = 0;
            $this->crow++;
         }
         //$this->WriteNumber_pos( $this->crow, $this->ccol, &$value );
		//Call-time pass-by-reference has been deprecated
		$this->WriteNumber_pos( $this->crow, $this->ccol, $value );
         $this->ccol++;
         return;
      }
 
      // insert a number, increment row,col automatically
      function InsertText( $value )
      {
         if ( $this->ccol == $this->totalcol ) {
            $this->ccol = 0;
            $this->crow++;
         }
         //$this->WriteText_pos( $this->crow, $this->ccol, &$value );
		 //Call-time pass-by-reference has been deprecated
		 $this->WriteText_pos( $this->crow, $this->ccol, $value );
         $this->ccol++;
         return;
      }
 
      // Change position of row,col
      function ChangePos( $newrow, $newcol )
      {
         $this->crow = $newrow;
         $this->ccol = $newcol;
         return;
      }
 
      // new line
      function NewLine()
      {
        $this->ccol = 0;
         $this->crow++;
         return;
      }
 
      // send generated xls as stream file
      /*
      function SendFile( $filename )
      {
         $this->filename = $filename;
         $this->SendFile();
      }*/
      
      // send generated xls as stream file
      function SendFile($filename = "sheet1")
      {
         $this->filename = $filename;
         $this->End();
         header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
         header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
         header ( "Pragma: no-cache" );
         header ( "Content-type: application/x-msexcel" );
         //header ( "Content-Disposition: attachment; filename=$this->filename.xls" );
         header ( "Content-Disposition: attachment; filename=$filename" );
         header ( "Content-Description: PHP Generated XLS Data" );
         print $this->xls_data;
      }
 
      function SendRawFile($filename = "sheet1") {
         $this->filename = $filename;
         $this->End();
         print $this->xls_data;
      }
 
      // change the default saving directory
      function ChangeDefaultDir( $newdir )
      {
        $this->default_dir = $newdir;
        return;
      }
 
      // Save generated xls file
      function SaveFile( $filename = "sheet1")
      {
         $this->filename = $filename;
         $this->End();
         //$this->fname = $this->default_dir."$this->dirsep".$this->filename;
          $this->fname = $this->filename;
		 if ( !stristr( $this->fname, ".xls" ) ) {
           $this->fname .= ".xls";
         }
        $fp = fopen( $this->fname, "wb" );
         fwrite( $fp, $this->xls_data );
         fclose( $fp );
         return;
      }
 
     // Get generated xls as specified type
      function GetXls( $type = 0 ) {
          if ( !$type && !$this->get_type ) {
             $this->SendFile();
          } else {
             $this->SaveFile();
          }
      }
 
      function setUpdateColWidth($state) {
          $this->updateColWidth = $state;
      }
    } // end of the class PHP_SIMPLE_XLS_GEN
 
}
 // end of ifdef PHP_SIMPLE_XLS_GEN
