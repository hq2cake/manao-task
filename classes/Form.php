<?php

abstract class Form
{
    abstract protected function validation();
    abstract protected function getErrorField();
}