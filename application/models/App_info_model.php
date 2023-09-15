<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_info_model extends CI_Model
{

	function AppName()
	{
		return 'INSPEKTORAT DAERAH KABUPATEN MERAUKE';
	}
	function AppDashboardName()
	{
		return 'SIPUT ANGGUN';
	}

	function AppNameTitleDashboard()
	{
		return 'Manajemen website';
	}

	function AppNameTitleClient()
	{
		return 'Selamat Datang di Website Konsultasi Inspektorat Kabupaten Merauke';
	}

	function AppDomain()
	{
		return 'inspektorat.merauke.go.id';
	}

	function AppNameCompany()
	{
		return 'Inspektorat Daerah Kabupaten Merauke';
	}

	function AppVersion()
	{
		return 'v1';
	}

	function AppCopyright()
	{
		return 'SIPUT ANGGUN';
	}

	function LinkCopyright()
	{
		return 'https://inspektorat.merauke.go.id';
	}

	function AppYear()
	{
		return '2023 - ' . date('Y');
	}
}

/* End of file App_info_model.php */
/* Location: ./application/models/App_info_model.php */