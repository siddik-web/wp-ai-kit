# Security Policy

## Principles

1. Least privilege
2. Defense in depth
3. Explicit trust boundaries
4. Secure defaults

---

## Input Handling

All input must be:
- validated
- sanitized
- typed

Never trust:
- query params
- request bodies
- headers
- cookies

---

## Authentication

Requirements:
- secure session handling
- expiration enforcement
- CSRF protection
- rate limiting

---

## Authorization

Every protected action must verify:
- identity
- permissions
- ownership

Never rely only on frontend checks.

---

## Secrets

Secrets must NEVER:
- exist in source control
- appear in logs
- appear in client bundles

Use environment variables or secret managers.

---

## Database

Always:
- use parameterized queries
- validate inputs
- enforce constraints

Never:
- concatenate SQL
- trust ORM safety blindly

---

## File Uploads

Validate:
- MIME type
- extension
- size
- content

Store outside executable paths where possible.

---

## Dependencies

Regularly:
- audit dependencies
- remove unused packages
- patch vulnerabilities

Minimize dependency count.

---

## XSS Prevention

Always escape output contextually:
- HTML
- attributes
- URLs
- JS contexts

---

## CSP

Use Content Security Policy where possible.

Prefer:
- nonces
- strict policies

Avoid:
- unsafe-inline

---

## Incident Handling

Security issues require:
- reproduction steps
- impact analysis
- mitigation plan
- postmortem documentation