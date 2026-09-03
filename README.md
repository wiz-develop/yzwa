# YZWA WordPress source

- `main`: production source captured before this upgrade work.
- `test`: code deployed to `yzwa.wiz-services.com` for migration and upgrade QA.

Database dumps, credentials, user uploads, caches, logs, and backup archives are intentionally excluded.

See [docs/UPGRADE-2026-09-03.md](docs/UPGRADE-2026-09-03.md) before preparing a production release. The `test` branch contains the designated migration-source site, so it must not be deployed wholesale over production.
