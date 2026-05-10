# CONVENTIONS.md

This file documents engineering conventions. See the main copy at [../../doc/CONVENTIONS.md](../../doc/CONVENTIONS.md).

For quick reference in this context folder, key conventions:

## File Structure

Group by feature first, not by file type:

```
features/
  checkout/
    components/
    services/
    tests/
```

Not: components/, services/, utils/

## Naming

- Variables: Descriptive names (avoid data, temp, item, thing)
- Functions: Describe behavior (calculateInvoiceTotal, not handleData)
- Files: Match purpose

## Comments

Comments explain **WHY**, not **WHAT**.

## Logging

- Include context and identifiers
- Never log secrets

## Git

Commit messages: imperative, scoped.

Example: `feat(auth): add session expiration handling`

**See [../../doc/CONVENTIONS.md](../../doc/CONVENTIONS.md) for full details.**
