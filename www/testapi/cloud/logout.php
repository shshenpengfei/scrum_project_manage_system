<?php
require '../lib.php';

TestUser::user()->logout();
header('Location:../');