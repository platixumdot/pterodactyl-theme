# REST API

Alle Endpunkte nutzen den Prefix `api/theme` (konfigurierbar über `config('pltx-theme.api.prefix')`).

## Endpunkte

| Methode | Endpunkt | Beschreibung |
|---|---|---|
| `GET` | `/api/theme/status` | Liefert Status, Incidents und Wartungen |
| `GET` | `/api/theme/update` | Liefert aktuelle und neueste Theme-Version |
| `GET` | `/api/theme/tickets` | Liefert die Ticketliste |
| `POST` | `/api/theme/tickets` | Erstellt ein Ticket |
| `GET` | `/api/theme/billing` | Liefert Billing-Daten |

## Hinweise

- Die Endpunkte sind für externe Dashboards und Integrationen gedacht.
- Standardmäßig ist ein Rate-Limit von `120` Requests pro Minute konfiguriert (`config('pltx-theme.api.rate_limit')`).
- Für produktiven Einsatz sollten Authentifizierung und Rate-Limiting projektseitig angepasst werden.
