<?php

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit();
  }
}

function output_message($message="") {
  if (!empty($message)) {
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = "../includes{$class_name}.php";
    if(file_exists($path)) {
      require_once($path);
    } else {
      die ("The File {$class_name} Could Not Be Found");
    }
}

function include_layout_template($template="") {
  include(__DIR__ .DS. '../public'.DS.'layouts'.DS.$template);
}

function log_action($action, $message="") {
  $logfile = __DIR__ .DS."../logs/log.txt";
  $new = file_exists($logfile) ? false : true;
  if ($handle = fopen($logfile, 'a')) {
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
    $content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if ($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function scrub_output($value) {
  return htmlspecialchars(strip_tags($value));
}

?>
