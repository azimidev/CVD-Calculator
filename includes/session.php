<?php

  session_start();

  function message() {
      if (isset($_SESSION["message"])) {
          $output = "<div class=\"container\"><div class=\"well\">";
          $output .= htmlentities($_SESSION["message"]);
          $output .= "</div></div>";

          // clear message after use
          $_SESSION["message"] = null;

          return $output;
      }
  }

  function errors() {
      if (isset($_SESSION["errors"])) {
          $errors = $_SESSION["errors"];

          // clear message after use
          $_SESSION["errors"] = null;

          return $errors;
      }
  }
?>