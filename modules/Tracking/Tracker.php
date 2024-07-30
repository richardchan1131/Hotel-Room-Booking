<?php


namespace Modules\Tracking;


use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Tracking\Models\TrackingDevice;
use Modules\Tracking\Models\TrackingEvent;
use Modules\Tracking\Models\TrackingGeoip;
use Modules\Tracking\Models\TrackingLog;
use Modules\Tracking\Models\TrackingPath;
use Modules\Tracking\Models\TrackingSession;
use Modules\Tracking\Models\TrackingUser;
use Modules\Tracking\Models\TrackingUtm;
use Modules\Tracking\Parsers\UserAgentParser;

class Tracker
{

    protected $geoip_reader;

    protected $last_hash_data = [];

    protected ?TrackingDevice $device = null;
    protected ?TrackingUser $user = null;
    protected ?TrackingPath $path = null;
    protected ?TrackingSession $session = null;
    protected ?TrackingUtm $utm = null;

    public function path($path = ''){
        if($this->path) return $this->path;
        return $this->path =  TrackingPath::firstOrCreate(['path'=>$path ? $path : request()->path()]);
    }
    public function user(){

        if($this->user) return $this->user;

        if($auth_user = auth()->user()){
            $user = TrackingUser::query()->where('user_id',$auth_user->id)->first();
            if(!$user){
                $user = TrackingUser::create(
                   [
                       'user_id'=>auth()->id(),
                       'device_id'=>$this->device()->id,
                       'client_ip'=>$this->client_ip(),
                       'is_robot'=>UserAgentParser::isBot(),
                   ]
                );
            }
        }else {

            $user = TrackingUser::firstOrCreate([
                'device_id' => $this->device()->id,
                'client_ip' => $this->client_ip(),
                'is_robot' => UserAgentParser::isBot(),
            ]);
        }
        return $this->user = $user;
    }

    public function device(){
        if($this->device) return $this->device;

        $parser = UserAgentParser::getParser();

        return $this->device = TrackingDevice::firstOrCreate([
            'brand'=>$parser->device->brand,
            'model'=>$parser->device->model,
            'platform'=>$parser->os->family ?? '',
            'platform_version'=>$parser->os->major,
            'is_mobile'=>UserAgentParser::isMobile() ? 1 : 0,
            'browser'=>$parser->ua->family,
            'browser_version'=>$parser->ua->major,
        ]);
    }

    public function utm(){
        if($this->utm) return $this->utm;

        $data = [
            'utm_campaign'=>$_COOKIE['utm_campaign'] ?? '',
            'utm_source'=>$_COOKIE['utm_source'] ?? '',
            'utm_medium'=>$_COOKIE['utm_medium'] ?? '',
            'utm_content'=>$_COOKIE['utm_content'] ?? '',
            'utm_term'=>$_COOKIE['utm_term'] ?? ''
        ];
        $data = array_filter($data);

        if(!empty($data)){
            return $this->utm = TrackingUtm::firstOrCreate($data);
        }
        return $this->utm = new TrackingUtm();
    }

    function client_ip() {
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = '';

        return $ipaddress;
    }
    public function event($name){
        return TrackingEvent::firstOrCreate(['name'=>strtolower($name)]);
    }

    /**
     * @param $name
     * @param array $data
     * @param int $timeout_seconds
     * @return TrackingLog
     */
    public function track($name,$data = [],$timeout_seconds = 5 * MINUTE_IN_SECONDS){
        $event = $this->event($name);
        $user = $this->user();

        $data['event_id'] = $event->id;
        $data['user_id'] = $user->id;

        if($timeout_seconds){
            $find = TrackingLog::query()->where($data)->where('created_at','>=',date('Y-m-d H:i:s',strtotime('- '.$timeout_seconds.' seconds')))->first('id');
            if($find){
                return $find;
            }
        }
        return $this->addLog($data);
    }

    public function addLog($data = []){

        $path = $this->path();
        $geoip = $this->geoip();
        $utm = $this->utm();
        $device = $this->device();


        $raws = [
            'path_id'=>$path->id,
            'method'=>request()->method(),
            'is_ajax'=>request()->isXmlHttpRequest(),
            'browser_lang'=>$this->browserLang(),
            'utm_id'=>$utm->id,
            'geoip_id'=>$geoip->id,
            'device_id'=>$device->id,
            'country'=>$geoip->countr_code,
            'client_ip'=>$this->client_ip(),
        ];
        if(!empty($data)){
            foreach ($data as $k=>$v){
                $raws[$k] = $v;
            }
        }
        $event = new TrackingLog($raws);

        $event->save();
        return $event;
    }

    public function browserLang(){
        if(empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return '';

        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    }

    public function geoip($ip_address = ''){
        if(!$ip_address) $ip_address = $this->client_ip();

        try {
            $record = $this->geoip_reader()->city($ip_address);
            if ($record) {
                $data = [
                    'lat' => $record->location->latitude ?? '',
                    'lng' => $record->location->longitude ?? '',
                    'country_code' => $record->country->isoCode ?? '',
                    'country_name' => $record->country->name ?? '',
                    'city' => $record->city->name ?? '',
                    'region' => $record->subdivisions[0]->name ?? '',
                    'postal_code' => $record->postal->code ?? '',
                    'area_code' => $record->subdivisions[0]->isoCode ?? '',
                    'continent_code' => $record->continent->code ?? '',
                ];

                foreach ($data as $k => $v) {
                    if (empty($v)) unset($data[$k]);
                }
                if (!empty($data)) {
                    return TrackingGeoip::firstOrCreate($data);
                }
            }
        }catch (\Throwable $throwable){
            Log::debug($throwable->getMessage());
        }

        return new TrackingGeoip();
    }

    /**
     * @return mixed
     * @throws \GeoIp2\Database\Reader
     */
    public function geoip_reader(){

        if(!$this->geoip_reader){
            $reader = new Reader(resource_path(env('GEOIP_DB_PATH','GeoLite2-City_20210622/GeoLite2-City.mmdb')));
            $this->geoip_reader = $reader;
        }
        return $this->geoip_reader;
    }

    public function sign($data){
        $data['t'] = time();
        $string = http_build_query($data);

        $data['hash'] = $this->encrypt($string);
        return base64_encode(http_build_query($data));
    }

    public function enable(){
        return setting_item('tracking_enable');
    }

    public function eventSecret($event_name, $object){
        if(!$this->enable()) return;

        if (!empty($object->status) && $object->status == 'draft') return;
        $data = [
            'e'=>$event_name,
            'i'=>$object->id,
            'm'=>$object->type ? $object->type : 'user',
            'v'=>$object->type == 'user' ? $object->id : $object->create_user,
            'c'=>$object->type == 'user' ? $object->cpc_value : ($object->author->cpc_value ?? setting_item('cost_per_click'))
        ];
        return $this->sign($data);
    }

    public function parseRequest(Request  $request){
        $code = $request->query('code');
        if($code){
            parse_str(base64_decode($code),$data);
            if(!empty($data['hash']) and !empty($data['t']) and $data['t'] > strtotime('-6 hours')){
                $request_hash = $data['hash'];
                unset($data['hash']);

                if($request_hash == $this->encrypt(http_build_query($data))){
                    $this->last_hash_data = $data;
                }
            }
        }
    }

    protected function encrypt($string){
        return hash_hmac("sha256",$string,env("APP_KEY"));
    }

    public function getEncodeParam($k){
        return $this->last_hash_data[$k] ?? '';
    }

    public function isBotDetected(){
        if(empty($_SERVER['HTTP_USER_AGENT'])) return true;

        if ( preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus/i', $_SERVER['HTTP_USER_AGENT'])
        ) {
            return true; // 'Above given bots detected'
        }

        return false;
    }

}
