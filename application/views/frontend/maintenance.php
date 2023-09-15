<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<title>Site Maintenance</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
<link href="<?= base_url(); ?>assets/frontend/themes/2023/logo-merauke.ico" rel="icon">
<style>
    html,
    body {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100%;
    }

    * {
        box-sizing: border-box;
    }

    body {
        text-align: center;
        padding: 0;
        background: #d6433b;
        color: #fff;
        font-family: Open Sans;
    }

    h1 {
        font-size: 50px;
        font-weight: 100;
        text-align: center;
    }

    body {
        font-family: Open Sans;
        font-weight: 100;
        font-size: 20px;
        color: #fff;
        text-align: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    article {
        display: block;
        width: 700px;
        padding: 50px;
        margin: 0 auto;
    }

    a {
        color: #fff;
        font-weight: bold;
    }

    a:hover {
        text-decoration: none;
    }

    svg {
        width: 75px;
        margin-top: 1em;
    }
</style>

<article>
    <img class="img-fluid" src="<?= base_url(); ?>assets/backend/images/logo-pps.png" style="width: 20%;" />
    <h1>Website dalam pemeliharaan</h1>
    <div>
        <p>Sebelumnya, Kami memohon maaf atas ketidaknyamanan ini. Saat ini kami beritahukan kepada Masyarakat, bahwa sistem sedang dalam proses perbaikan/pemeliharaan. Untuk sementara, Anda dapat mengakses <a href="https://papuaselatan.go.id/">Portal provinsi</a> untuk informasi lainnya.!</p>
        <p>&mdash;  <?= $this->app_info_model->AppName(); ?></p>
    </div>
</article>