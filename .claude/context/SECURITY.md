# SECURITY.md

This file documents security requirements. See the main copy at [../../doc/SECURITY.md](../../doc/SECURITY.md).

## Security-First Principle

All input is untrusted.

Always:
- Validate input
- Sanitize data
- Escape output contextually
- Enforce permissions
- Verify authorization

Never:
- Trust client input
- Interpolate raw SQL
- Expose credentials
- Bypass capability checks
- Disable CSRF/nonces casually
- Leak sensitive logs

## Security Checklist

- [ ] Input validation
- [ ] No raw SQL interpolation
- [ ] Credentials protected
- [ ] Permission checks present
- [ ] Authorization verified
- [ ] Data encrypted in transit/at rest
- [ ] No secrets in logs
- [ ] Dependency vulnerabilities checked

**See [../../doc/SECURITY.md](../../doc/SECURITY.md) for application-specific requirements.**
