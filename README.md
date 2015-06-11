# Momondo API
[http://www.momondo.com/](http://www.momondo.com)
> **Unofficial!**

## Documentation

<a name="flights" />
### Flights

- [Complete Airports](#complete-airports)
- [Get Search Link](#get-search-link)
- [Get Search Results](#get-search-results)
- [Price Calendar](#price-calendar)
- [Currency](#currency)

<a name="airports" />
#### Complete Airports

Request:

`POST http://android.momondo.com/api/2.1/services.asmx/CompleteAirports`

`Content-Type: application/json`

```json
{
  "count": "10",
  "language": "en",
  "prefixText": "led"
}
```

Response:

```json
{
  "d": [
    {
      "__type": "SkyGate.SpeedFares.Momondo.AirportResult",
      "Code": "LED",
      "Name": "Saint Petersburg",
      "Display": "Saint Petersburg (LED), Russian Federation",
      "MainCity": "Saint Petersburg",
      "Country": "Russian Federation",
      "DistanceKM": 0,
      "MainCityCode": "LED"
    },
    ...
  ]
}
```

<a name="search-link" />
#### Get Search Link

Request:

`POST http://android.momondo.com/api/3.0/FlightSearch`

`Content-Type: application/json`

```json
{
  "Culture": "en-US",
  "Market": "US",
  "Application": "Android",
  "Consumer": "momondo",
  "Mix": "NONE",
  "Mobile": true,
  "TicketClass": "ECO",
  "AdultCount": 1,
  "ChildAges": [],
  "Segments": [
    {
      "Origin": "LED",
      "Destination": "MOW",
      "Departure": "YYYY-MM-DD"
    },
    {
      "Origin": "MOW",
      "Destination": "LED",
      "Departure": "YYYY-MM-DD"
    }
  ]
}
```

Response:

```json
{
  "Segments": [
    {
      "Origin": {
        "Aliases": null,
        "ContinentCode": null,
        "ContinentGroup": 0,
        "CountryCode": "RU",
        "CountryName": "Russian Federation",
        "DST": null,
        "DisplayName": "Saint Petersburg (LED), Russian Federation",
        "Iata": "LED",
        "IataLink": false,
        "Icao": null,
        "Latitude": 59.8002777,
        "Longitude": 30.2625,
        "MainCityCode": "LED",
        "MainCityDisplayName": "Saint Petersburg (LED), Russian Federation",
        "MainCityName": "Saint Petersburg",
        "Name": "Pulkovo",
        "Priority": 201,
        "StateCode": "",
        "StateName": "",
        "TimeZone": 0
      },
      "Destination": {
        "Aliases": null,
        "ContinentCode": null,
        "ContinentGroup": 0,
        "CountryCode": "RU",
        "CountryName": "Russian Federation",
        "DST": null,
        "DisplayName": "Moscow (MOW), Russian Federation",
        "Iata": "MOW",
        "IataLink": false,
        "Icao": null,
        "Latitude": 55.7557869,
        "Longitude": 37.6176338,
        "MainCityCode": "MOW",
        "MainCityDisplayName": "Moscow (MOW), Russian Federation",
        "MainCityName": "Moscow",
        "Name": "Moscow",
        "Priority": 483,
        "StateCode": "",
        "StateName": "",
        "TimeZone": 0
      },
      "Departure": "YYYY-MM-DDT00:00:00"
    },
    {
      "Origin": {
        "Aliases": null,
        "ContinentCode": null,
        "ContinentGroup": 0,
        "CountryCode": "RU",
        "CountryName": "Russian Federation",
        "DST": null,
        "DisplayName": "Moscow (MOW), Russian Federation",
        "Iata": "MOW",
        "IataLink": false,
        "Icao": null,
        "Latitude": 55.7557869,
        "Longitude": 37.6176338,
        "MainCityCode": "MOW",
        "MainCityDisplayName": "Moscow (MOW), Russian Federation",
        "MainCityName": "Moscow",
        "Name": "Moscow",
        "Priority": 483,
        "StateCode": "",
        "StateName": "",
        "TimeZone": 0
      },
      "Destination": {
        "Aliases": null,
        "ContinentCode": null,
        "ContinentGroup": 0,
        "CountryCode": "RU",
        "CountryName": "Russian Federation",
        "DST": null,
        "DisplayName": "Saint Petersburg (LED), Russian Federation",
        "Iata": "LED",
        "IataLink": false,
        "Icao": null,
        "Latitude": 59.8002777,
        "Longitude": 30.2625,
        "MainCityCode": "LED",
        "MainCityDisplayName": "Saint Petersburg (LED), Russian Federation",
        "MainCityName": "Saint Petersburg",
        "Name": "Pulkovo",
        "Priority": 201,
        "StateCode": "",
        "StateName": "",
        "TimeZone": 0
      },
      "Departure": "YYYY-MM-DDT00:00:00"
    }
  ],
  "SearchId": "aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee",
  "EngineId": <int>,
  "AdultCount": 1,
  "ChildCount": 0,
  "InfantCount": 0,
  "ChildAges": [],
  "TicketClass": "ECO",
  "Culture": "en-US"
}
```

<a name="search-results" />
#### Get Search Results

Get SearchId && EngineId From Previous Results ([Get Search Link](#get-search-link)) and Make URL:

Request:

`GET http://android.momondo.com/api/3.0/FlightSearch/<SearchId>/<EngineId>`

Do [Get Search Results](#get-search-results) While Response.Done == false. If True Then Complete.

Response:

```json
{
  "SearchId": <SearchId>,
  "EngineId": <EngineId>,
  "Done": <bool>,
  "Error": <bool>,
  "ErrorMessage": null,
  "ResultNumber": 0,
  "Summary": {
    "BestOfferIndex": <int>,
    "BestOfferSupplierIndex": <int>,
    "CheapestOfferIndex": <int>,
    "CheapestOfferSupplierIndex": <int>,
    "FastestOfferIndex": <int>,
    "FastestOfferSupplierIndex": <int>,
    "MaxDuration": <int>,
    "MaxPrice": <double>,
    "MaxScore": <double>,
    "MinDuration": <int>,
    "MinPrice": <double>,
    "MinScore": <double>
  },
  "Airports": [
    {
      "Aliases": null,
      "ContinentCode": "EU",
      "ContinentGroup": 1,
      "CountryCode": "RU",
      "CountryName": "Russian Federation",
      "DST": "",
      "DisplayName": "Saint Petersburg (LED), Russian Federation",
      "Iata": "LED",
      "IataLink": false,
      "Icao": "ULLI",
      "Latitude": 59.8002777,
      "Longitude": 30.2625,
      "MainCityCode": "LED",
      "MainCityDisplayName": "Saint Petersburg (LED), Russian Federation",
      "MainCityName": "Saint Petersburg",
      "Name": "Pulkovo",
      "Priority": 201,
      "StateCode": "",
      "StateName": "",
      "TimeZone": <int>
    },
    ...
  ],
  "Airlines": [
    {
      "Iata": "UN",
      "Icao": "TSO",
      "Name": "Transaero Airlines",
      "ShortName": null
    },
    ...
  ],
  "Fees": [
    {
      "AirlineIndex": null,
      "Description": "American Express",
      "MaxAmountEUR": <double>,
      "MinAmountEUR": <double>,
      "PaymentId": 1,
      "Type": "Payment"
    },
    ...
  ],
  "Flights": [
    {
      "DirectAirlineIndex": -1,
      "Key": "UN0000LED00000000DME0000,UN0000VKO00000000LED0000",
      "SegmentIndexes": [
        0,
        1
      ],
      "TicketClassIndex": 0
    },
    ...
  ],
  "Legs": [
    {
      "AirlineIndex": 0,
      "Arrival": "YYYY-MM-DDT10:00:00",
      "Departure": "YYYY-MM-DDT11:00:00",
      "DestinationIndex": 2,
      "Duration": 90,
      "FlightNumber": 33,
      "Key": "UN0000LED00000000DME0000",
      "OriginIndex": 0,
      "StopOverCodeIndexes": null,
      "StopOvers": 0
    },
    ...
  ],
  "MixOffers": null,
  "Offers": [
    {
      "AdultPrice": <double>,
      "AdultPriceEUR": <double>,
      "AdultPriceExclTax": <double>,
      "Currency": "USD",
      "Deeplink": <link>,
      "FeeIndexes": [
        0,
        2,
        3,
        4,
        5,
        6
      ],
      "FlightIndex": 6,
      "MobileDeepLink": null,
      "Score": <double>,
      "TicketClassIndex": 2,
      "TotalIsCalculated": false,
      "TotalPrice": <double>,
      "TotalPriceEUR": <double>,
      "TotalPriceExclTax": <double>
    },
    ...
  ],
  "Segments": [
    {
      "Duration": 90,
      "Key": "UN0000LED00000000DME0000",
      "LegIndexes": [0]
    },
    ...
  ],
  "Suppliers": [
    {
      "AffiliateImageUrl": "",
      "AirlineIataCode": null,
      "BaseRedirectUrl": <link>,
      "Cached": false,
      "Deeplink": null,
      "DisplayName": "Smartfares",
      "Error": null,
      "EstimatedTaxes": false,
      "Factor": <double>,
      "Group": 2,
      "LoginId": null,
      "MobileDeeplink": null,
      "MobileSite": false,
      "OfferIndexes": [
        0,
        1,
        2,
        ...
      ],
      "QuoteTime": "YYYY-MM-DDT23:53:20.1734523+00:00",
      "SearchDestinationIndex": 1,
      "SearchOriginIndex": 0,
      "SupplierId": "Smartfares"
    },
    ...
  ],
  "TicketClasses": [
    {
      "Code": "ECO",
      "Name": ""
    },
    {
      "Code": "ECO",
      "Name": "Economy"
    },
    {
      "Code": "ECO",
      "Name": "EconomyLow"
    },
    {
      "Code": "ECO",
      "Name": "Economy/Coach/Economy/Coach"
    }
  ]
}
```

<a name="calendar" />
#### Price Calendar

Request:

`POST http://android.momondo.com/api/3.0/Flights.PriceCalendar/Post`

`Content-Type: application/json`

```json
{
  "culture": "en",
  "currency": "USD",
  "destCode": "MOW",
  "firstDate": "YYYY-MM-DD",
  "origCode": "LED",
  "lastDate": "YYYY-MM-DD",
  "maxStops": 2,
  "isMobile": false,
  "includeNearby": true,
  "requestId": 14,
  "segment": 0,
  "segments": 1
}
```

Response:

```json
{
  "Currency": "USD",
  "Origin": {
    "Iata": "LED",
    "Name": "Pulkovo",
    "ContinentCode": "EU",
    "Priority": 201,
    "MainCityCode": "LED",
    "MainCityName": "Saint Petersburg",
    "StateCode": "",
    "StateName": "",
    "CountryCode": "RU",
    "CountryName": "Russian Federation",
    "Longitude": 30.2625,
    "Latitude": 59.8002777,
    "Type": 1
  },
  "Destination": {
    "Iata": "MOW",
    "Name": "Moscow",
    "ContinentCode": "EU",
    "Priority": 483,
    "MainCityCode": "MOW",
    "MainCityName": "Moscow",
    "StateCode": "",
    "StateName": "",
    "CountryCode": "RU",
    "CountryName": "Russian Federation",
    "Longitude": 37.6176338,
    "Latitude": 55.7557869,
    "Type": 1
  },
  "Data": [
    {
      "Date": "YYYY-MM-DDT00:00:00",
      "Price": 55
    },
    {
      "Date": "YYYY-MM-DDT00:00:00",
      "Price": 60
    },
    ...
  ],
  "RequestId": "14"
}
```

<a name="currency" />
#### Currency

Rate EUR:XXX

Request:

`GET http://android.momondo.com/api/3.0/Currency/List?all=all`

Response:

```json
[
  {
    "Code": "AED",
    "Name": "Emirati Dirham",
    "Symbol": "",
    "Format": "",
    "Rate": <double>,
    "Priority": 300
  },
  ...
]
```

## Team
- Analyzed by [Secator](http://secator.com)
- Coding by [5MS](http://5ms.ru)
