<?php

class DateHelper {

    public static function FormatarDataParaBanco($data = null, $timestamp = false) {

        if ($data == null)
            $data = $timestamp == false ? date('d/m/Y') : date('d/m/Y h:i:s');

        if (strlen($data) == 10) {
            if (substr_count($data, "/") == 2) {
                $d = explode("/", $data);
                $data = mktime("0", "0", "0", $d[1], $d[0], $d[2]);
                return $timestamp == false ? date("Y-m-d", $data) : date("Y-m-d H:i:s", $data);
            }
        } elseif (strlen($data) > 10) {
            if (substr_count($data, "/") == 2 && substr_count($data, ":") == 2) {
                $d = explode("/", substr($data, 0, 10));
                $h = explode(":", substr($data, 11, strlen($data)));

                $data = mktime($h[0], $h[1], $h[2], $d[1], $d[0], $d[2]);
                return $timestamp == false ? date("Y-m-d", $data) : date("Y-m-d H:i:s", $data);
            }
        }
        return $data;
    }

    public static function FormatarDataBancoParaPHP($data = null, $timestamp = false) {

        if ($data == null)
            $data = $timestamp == false ? date('d/m/Y') : date('d/m/Y H:i:s');

        if (strlen($data) == 10) {
            if (substr_count($data, "-") == 2) {
                return $timestamp == false ? date("d/m/Y", strtotime($data)) : date("d/m/Y H:i:s", strtotime($data));
            }
        } elseif (strlen($data) > 10) {
            if (substr_count($data, "-") == 2 && substr_count($data, ":") == 2) {
                $d = explode("-", substr($data, 0, 10));
                $h = explode(":", substr($data, 11, strlen($data)));
                return $timestamp == false ? date("d/m/Y", strtotime($data)) : date("d/m/Y H:i:s", strtotime($data));
            }
        }
        return $data;
    }

}

?>
