<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seo_model extends CI_Model
{

	function SetHeaderTitle()
	{
		$Title = '';
		$Title = $this->uri->segment(3, 0);
		if ($Title == null) {
			return ucwords($this->app_info_model->AppNameTitleClient());
		} else {
			$Segment4 = $this->uri->segment(4, 0);
			if ($Segment4 == null) {
				$Title = str_replace("-", " ", $Title);
				$Title = ucwords($Title);
				return $Title . ' | ' . $this->app_info_model->AppNameTitleClient();
			} else {
				$Segment4 = str_replace("-", " ", $Segment4);
				$Segment4 = ucwords($Segment4);
				return $Segment4 . ' | ' . $this->app_info_model->AppNameTitleClient();
			}
		}
	}

	function SetMetaKeywords()
	{
		$Keywords = '';
		$Keywords = $this->uri->segment(3, 0);
		if ($Keywords == null) {
			return ucwords($this->app_info_model->AppNameCompany());
		} else {
			$Segment4 = $this->uri->segment(4, 0);
			if ($Segment4 == null) {
				$Keywords = explode("-", $Keywords);
				return implode(", ", $Keywords);
			} else {
				$Segment4 = explode("-", $Segment4);
				return implode(", ", $Segment4);
			}
		}
	}

	function ParserUserAgent($u_agent = null)
	{
		if (is_null($u_agent)) {
			if (isset($_SERVER['HTTP_USER_AGENT'])) {
				$u_agent = $_SERVER['HTTP_USER_AGENT'];
			} else {
				throw new \InvalidArgumentException('parse_user_agent requires a user agent');
			}
		}
		$platform = null;
		$browser  = null;
		$version  = null;
		$empty = array('platform' => $platform, 'browser' => $browser, 'version' => $version);
		if (!$u_agent) return $empty;
		if (preg_match('/\((.*?)\)/im', $u_agent, $parent_matches)) {
			preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
						(?:\ [^;]*)?
						(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
			$priority           = array('Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'CrOS', 'Linux', 'X11');
			$result['platform'] = array_unique($result['platform']);
			if (count($result['platform']) > 1) {
				if ($keys = array_intersect($priority, $result['platform'])) {
					$platform = reset($keys);
				} else {
					$platform = $result['platform'][0];
				}
			} elseif (isset($result['platform'][0])) {
				$platform = $result['platform'][0];
			}
		}
		if ($platform == 'linux-gnu' || $platform == 'X11') {
			$platform = 'Linux';
		} elseif ($platform == 'CrOS') {
			$platform = 'Chrome OS';
		}
		preg_match_all(
			'%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
						Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|
						Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
						Valve\ Steam\ Tenfoot|
						NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
						(?:\)?;?)
						(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
			$u_agent,
			$result,
			PREG_PATTERN_ORDER
		);
		// If nothing matched, return null (to avoid undefined index errors)
		if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
			if (preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result)) {
				return array('platform' => $platform ?: null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null);
			}
			return $empty;
		}
		if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result)) {
			$rv_result = $rv_result['version'];
		}
		$browser = $result['browser'][0];
		$version = $result['version'][0];
		$lowerBrowser = array_map('strtolower', $result['browser']);
		$find = function ($search, &$key) use ($lowerBrowser) {
			$xkey = array_search(strtolower($search), $lowerBrowser);
			if ($xkey !== false) {
				$key = $xkey;
				return true;
			}
			return false;
		};
		$key  = 0;
		$ekey = 0;
		if ($browser == 'Iceweasel') {
			$browser = 'Firefox';
		} elseif ($find('Playstation Vita', $key)) {
			$platform = 'PlayStation Vita';
			$browser  = 'Browser';
		} elseif ($find('Kindle Fire', $key) || $find('Silk', $key)) {
			$browser  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
			$platform = 'Kindle Fire';
			if (!($version = $result['version'][$key]) || !is_numeric($version[0])) {
				$version = $result['version'][array_search('Version', $result['browser'])];
			}
		} elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
			$browser = 'NintendoBrowser';
			$version = $result['version'][$key];
		} elseif ($find('Kindle', $key)) {
			$browser  = $result['browser'][$key];
			$platform = 'Kindle';
			$version  = $result['version'][$key];
		} elseif ($find('OPR', $key)) {
			$browser = 'Opera Next';
			$version = $result['version'][$key];
		} elseif ($find('Opera', $key)) {
			$browser = 'Opera';
			$find('Version', $key);
			$version = $result['version'][$key];
		} elseif ($find('Midori', $key)) {
			$browser = 'Midori';
			$version = $result['version'][$key];
		} elseif ($browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $ekey)) {
			$browser = 'MSIE';
			if ($find('IEMobile', $key)) {
				$browser = 'IEMobile';
				$version = $result['version'][$key];
			} elseif ($ekey) {
				$version = $result['version'][$ekey];
			} else {
				$version = $rv_result ?: $result['version'][$key];
			}
			if (version_compare($version, '12', '>=')) {
				$browser = 'Edge';
			}
		} elseif ($find('Vivaldi', $key)) {
			$browser = 'Vivaldi';
			$version = $result['version'][$key];
		} elseif ($find('Valve Steam Tenfoot', $key)) {
			$browser = 'Valve Steam Tenfoot';
			$version = $result['version'][$key];
		} elseif ($find('Chrome', $key) || $find('CriOS', $key)) {
			$browser = 'Chrome';
			$version = $result['version'][$key];
		} elseif ($browser == 'AppleWebKit') {
			if (($platform == 'Android' && !($key = 0))) {
				$browser = 'Android Browser';
			} elseif (strpos($platform, 'BB') === 0) {
				$browser  = 'BlackBerry Browser';
				$platform = 'BlackBerry';
			} elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
				$browser = 'BlackBerry Browser';
			} elseif ($find('Safari', $key)) {
				$browser = 'Safari';
			} elseif ($find('TizenBrowser', $key)) {
				$browser = 'TizenBrowser';
			}
			$find('Version', $key);
			$version = $result['version'][$key];
		} elseif ($key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser']))) {
			$key = reset($key);
			$platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
			$browser  = 'NetFront';
		}
		return array('platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null);
	}

	function AddNewsRating($IdNews)
	{
		$query = $this->db->select('ReadRating');
		$query = $this->db->where('IdNews', $IdNews);
		$query = $this->db->get('news');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$ReadRating = $row->ReadRating;
		} else {
			$ReadRating = 0;
		}

		$this->db->where('IdNews', $IdNews);
		$this->db->update('news', array('ReadRating' => $ReadRating + 1));
	}
}

/* End of file Seo_model.php */
/* Location: ./application/models/Seo_model.php */