<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addDiv($id, $label)
{
    return "<div class='form-group'>" . form_label($label, $id);
}

function form_input_div($data = '', $value = '', $extra = '')
{
    return addDiv($data['id'], $data['label']) . form_input($data, $value, $extra) . "</div>";
}

function form_textarea_div($data = '', $value = '', $extra = '')
{
    return addDiv($data['id'], $data['label']) . form_textarea($data, $value, $extra) . "</div>";
}

function form_dropdown_div($data = array(), $options = array(), $selected = array(), $extra = '')
{
    return addDiv($data['id'], $data['label']) . form_dropdown($data['name'], $options, $selected, $extra) . "</div>";
}

function form_submit_div($data = '', $value = '', $extra = '')
{
    return "<div class='form-group'>" . form_submit($data, $value, $extra) . "</div>";
}
