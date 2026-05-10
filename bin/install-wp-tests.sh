#!/usr/bin/env bash
set -euo pipefail

# Compatibility shim for legacy CI steps that expect this script.
# This repository currently runs PHP unit tests that do not depend on the
# WordPress core test scaffold.

DB_NAME="${1:-wordpress_test}"
DB_USER="${2:-root}"
DB_PASS="${3:-root}"
DB_HOST="${4:-localhost}"
WP_VERSION="${5:-latest}"
SKIP_DB_CREATE="${6:-true}"

echo "install-wp-tests.sh shim: no WordPress core test scaffold required."
echo "Args: db=${DB_NAME} user=${DB_USER} host=${DB_HOST} wp=${WP_VERSION} skip_db_create=${SKIP_DB_CREATE}"
echo "If WordPress integration tests are added, replace this shim with full setup."
