denggi_info
===========

Denggi Info is a REST web service serving Malaysia's dengue information taken from one of Malaysian Remote Sensing Agency

The web application provide HTTP API which return JSON data.

## How it work

**Request for state data**

	curl http://<domain>/negeri/johor

Will output:

[{"negeri": "JOHOR", "daerah": "BATU PAHAT", "lokaliti": "KG. ISTANA",
"kes_kumulatif": 3}, {"negeri": "JOHOR", "daerah": "KULAI JAYA",
"lokaliti": "TMN PUTRI BLOK 2", "kes_kumulatif": 5}, ... ]

**Request for daily data**

	curl http://<domain>/harian
	
Will output:

[{"negeri: "JOHOR", "jumlah_kes": 10, "kawasan_berisiko": 5},
"negeri": "SELANGOR", "jumlah_kes": 299, "kawasan_berisiko": 172},
...]