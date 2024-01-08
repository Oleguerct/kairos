<?php


namespace App\Service\ForecastAPIConnection;


use App\Model\ForecastDTO;

class ViasualcrossingAPIConnection implements ForecastAPIConnectionInterface
{
    const API_ENDPOINT = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/%s/last15days?key=%s';
    private $api_key;

    /**
     * ViasualcrossingAPIConnection constructor.
     */
    public function __construct()
    {
        $this->api_key = $_ENV['VISUALCROSSING_API_KEY'];
    }


    /**
     * @param string $location
     * @return ForecastDTO[]
     */
    public function getForecastsDTOs(string $location): array
    {

        $call_url = sprintf(self::API_ENDPOINT, $location, $this->api_key);

        $response = file_get_contents($call_url);

        //$response = $this->getFakeAPIResponse();
        $data = json_decode($response, true);

        $daysForecast = $data['days'];
        $forecastDTOs = [];

        foreach ($daysForecast as $day){
            $forecastDTOs[] = new ForecastDTO(
                location: $data['resolvedAddress'],
                tempMax: $day['tempmax'],
                tempMin: $day['tempmin'],
                tempMean: $day['temp'],
                humidity: $day['humidity'],
                precipProb: $day['precipprob'],
                windSpeed:$day['windspeed'],
                cloudCover:$day['cloudcover'],
                uvIndex:$day['uvindex'],
                day: new \DateTime($day['datetime'])
            );
        }

        return $forecastDTOs;
    }

    // TODO: remove fakeAPIResponse()
    private function getFakeAPIResponse(){
        return '{"queryCost":1,"latitude":42.0444,"longitude":2.91182,"resolvedAddress":"Bordils, Catalunya, Espanya","address":"Bordils","timezone":"Europe/Madrid","tzoffset":1,"description":"Cooling down with a chance of rain tomorrow, Wednesday & Thursday.","days":[{"datetime":"2024-01-04","datetimeEpoch":1704322800,"tempmax":15.1,"tempmin":4.2,"temp":10.1,"feelslikemax":15.1,"feelslikemin":4.2,"feelslike":10,"dew":7.3,"humidity":83.1,"precip":0,"precipprob":0,"precipcover":0,"preciptype":null,"snow":0,"snowdepth":0,"windgust":60.5,"windspeed":24.8,"winddir":208.9,"pressure":1014.1,"cloudcover":61.5,"visibility":16.5,"solarradiation":52.9,"solarenergy":4.5,"uvindex":4,"severerisk":10,"sunrise":"08:16:49","sunriseEpoch":1704352609,"sunset":"17:29:36","sunsetEpoch":1704385776,"moonphase":0.75,"conditions":"Partially cloudy","description":"Partly cloudy throughout the day.","icon":"partly-cloudy-day","stations":["LEGE","D9541","F0584","LFMP"],"source":"comb","hours":[{"datetime":"12:00:00","datetimeEpoch":1704366000,"temp":13.1,"feelslike":13.1,"humidity":79.96,"dew":9.8,"precip":0,"precipprob":0,"snow":0,"snowdepth":0,"preciptype":null,"windgust":48.2,"windspeed":16.6,"winddir":192,"pressure":1015.9,"visibility":10,"cloudcover":50,"solarradiation":403,"solarenergy":1.5,"uvindex":4,"severerisk":10,"conditions":"Partially cloudy","icon":"partly-cloudy-day","stations":["LEGE","F0584","LFMP"],"source":"obs"},{"datetime":"13:00:00","datetimeEpoch":1704369600,"temp":15.1,"feelslike":15.1,"humidity":67.37,"dew":9.1,"precip":0,"precipprob":0,"snow":0,"snowdepth":0,"preciptype":null,"windgust":56.2,"windspeed":23.4,"winddir":205.6,"pressure":1015,"visibility":24.1,"cloudcover":44.7,"solarradiation":80,"solarenergy":0.3,"uvindex":1,"severerisk":10,"conditions":"Partially cloudy","icon":"partly-cloudy-day","stations":null,"source":"fcst"}]}],"alerts":[{"event":"Moderate wind warning","headline":"Moderate wind warning. Ampurdán","ends":"2024-01-06T23:59:59","endsEpoch":1704581999,"onset":"2024-01-06T00:00:00","onsetEpoch":1704495600,"id":"2.49.0.0.724.0.ES.20240104103059.691703VIRM06231704364259","language":"en","link":"https://www.aemet.es/en/eltiempo/prediccion/avisos","description":"Maximum gust of wind: 80 km/h. Viento del noroeste. En Pirineos y Ampurdán, afectará a cotas altas y zonas expuestas."}],"stations":{"F5134":{"distance":15478,"latitude":41.964,"longitude":2.759,"useCount":0,"id":"F5134","name":"FW5134 Bescano ES","quality":0,"contribution":0},"AT619":{"distance":28204,"latitude":41.817,"longitude":3.061,"useCount":0,"id":"AT619","name":"EA3GKP-2 Platja d\'Aro Girona ES","quality":0,"contribution":0},"LEGE":{"distance":19904,"latitude":41.9,"longitude":2.77,"useCount":0,"id":"LEGE","name":"LEGE","quality":50,"contribution":0},"D9541":{"distance":56283,"latitude":41.974,"longitude":2.238,"useCount":0,"id":"D9541","name":"DW9541 Gurb ES","quality":0,"contribution":0},"F0584":{"distance":25192,"latitude":41.819,"longitude":2.89,"useCount":0,"id":"F0584","name":"FW0584 Llagostera ES","quality":0,"contribution":0},"LFMP":{"distance":76398,"latitude":42.73,"longitude":2.87,"useCount":0,"id":"LFMP","name":"LFMP","quality":50,"contribution":0}},"currentConditions":{"datetime":"12:15:00","datetimeEpoch":1704366900,"temp":14.1,"feelslike":14.1,"humidity":58.9,"dew":6.2,"precip":0,"precipprob":0,"snow":0,"snowdepth":0,"preciptype":null,"windgust":16,"windspeed":5.3,"winddir":142,"pressure":1016,"visibility":10,"cloudcover":50,"solarradiation":403,"solarenergy":1.5,"uvindex":4,"conditions":"Partially cloudy","icon":"partly-cloudy-day","stations":["F5134","AT619","LEGE"],"source":"obs","sunrise":"08:16:49","sunriseEpoch":1704352609,"sunset":"17:29:36","sunsetEpoch":1704385776,"moonphase":0.75}}';
    }




}