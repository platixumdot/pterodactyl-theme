# REST API

Alle Endpunkte nutzen den Prefix `api/theme`.

## Endpunkte
- `GET /api/theme/status` - Liefert Status, Incidents und Wartungen.
- `GET /api/theme/update` - Liefert aktuelle und neueste Theme-Version.
- `GET /api/theme/tickets` - Liefert die Ticketliste.
- `POST /api/theme/tickets` - Erstellt ein Ticket.
- `GET /api/theme/billing` - Liefert Billing-Daten.

## Hinweise
- Die Endpunkte sind für externe Dashboards und Integrationen gedacht.
- Für produktiven Einsatz sollten Authentifizierung und Rate Limiting projektseitig angepasst werden.
