#!/bin/sh
# =============================================================================
# prod-guard.sh — refuse to start a PRODUCTION container that still carries the
# sample secrets shipped in .env.example.
#
# WHY: .env.example must "copy and run" for dev, so it ships DB_PASSWORD=password,
# SC_DOCKER_DB_ROOT_PASSWORD=change_me_root and COMPOSE_PROFILES=db-local as
# active values. Copied verbatim to a server and started with
# docker-compose.prod.yml, the stack comes up and serves traffic with those
# sample passwords — silently. Same class of "operator forgot" mistake that the
# dev/prod identity split guards against (ADR installer-deploy_docker-dev-prod-
# safeguards, RISK-SEC-docker-sample-secrets-prod), so it fails loudly here.
#
# Scope, on purpose:
#   - runs only when APP_ENV=production (the compose file pins it on every PHP
#     service, so dev/local containers are never affected);
#   - compares LITERAL sample values only — it does not judge password strength,
#     so a legitimate remote-DB password is never blocked by mistake;
#   - exit 1 with a message naming the exact variable to fix. With
#     `restart: unless-stopped` the container keeps restarting and
#     `docker compose logs app` shows why — loud beats silent.
#
# Called by entrypoint.sh after the .env bootstrap step; also runnable directly:
#   APP_ENV=production DB_PASSWORD=password sh docker/php/prod-guard.sh ; echo $?
# PROD_GUARD_ENV_FILE overrides the .env path (tests).
# =============================================================================

[ "${APP_ENV:-}" = "production" ] || exit 0

env_file="${PROD_GUARD_ENV_FILE:-.env}"
failed=0

if [ "${DB_PASSWORD:-}" = "password" ]; then
    echo "[prod-guard] DB_PASSWORD is still the .env.example sample value 'password'." >&2
    failed=1
fi

# The MySQL root sample only matters when the bundled mysql-local actually
# starts (COMPOSE_PROFILES contains db-local). A remote-DB deployment can leave
# the line untouched.
if [ -f "$env_file" ] \
    && grep -Eq '^[[:space:]]*COMPOSE_PROFILES=[^#]*db-local' "$env_file" \
    && grep -Eq '^[[:space:]]*SC_DOCKER_DB_ROOT_PASSWORD=change_me_root([[:space:]]|$)' "$env_file"; then
    echo "[prod-guard] SC_DOCKER_DB_ROOT_PASSWORD is still the .env.example sample value 'change_me_root' while COMPOSE_PROFILES=db-local starts the bundled MySQL." >&2
    failed=1
fi

if [ "$failed" = 1 ]; then
    cat >&2 <<'EOF'
[prod-guard] Refusing to start a PRODUCTION container with sample secrets.
[prod-guard] Fix: edit .env on the host — set a real DB_PASSWORD (and
[prod-guard] SC_DOCKER_DB_ROOT_PASSWORD if you use the bundled MySQL, or set
[prod-guard] COMPOSE_PROFILES= to use a remote database) — then run:
[prod-guard]     docker compose -f docker-compose.prod.yml up -d
[prod-guard] (root password of mysql-local applies only on its FIRST start; if the
[prod-guard] data volume already exists, change the password inside MySQL too.)
EOF
    exit 1
fi

exit 0
