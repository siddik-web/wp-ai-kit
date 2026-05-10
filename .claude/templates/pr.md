---
name: Pull Request Template
description: Standard PR template for code reviews
---

# Pull Request

## Description

Brief description of what this PR does.

**Related Issue**: Fixes #123 (or relates to feature #456)

---

## Type of Change

- [ ] Bug fix (non-breaking change that fixes an issue)
- [ ] Feature (non-breaking change that adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to change)
- [ ] Documentation update
- [ ] Security improvement
- [ ] Performance improvement
- [ ] Refactoring (no functional change)

---

## Changes Made

- Item 1
- Item 2
- Item 3

---

## Architecture & Design

### Layers Affected
- [ ] UI Layer
- [ ] Application Layer
- [ ] Domain Layer

### Design Decisions

Explain key design decisions and alternatives considered.

---

## Breaking Changes

Describe any breaking changes and migration path (if applicable).

---

## Testing

- [ ] Unit tests added/updated
- [ ] Integration tests added/updated
- [ ] E2E tests added/updated
- [ ] All tests passing
- [ ] Coverage maintained

### Test Coverage

Describe what was tested and why.

---

## Security & Compliance

- [ ] Input validation verified
- [ ] No secrets in code or logs
- [ ] Permission checks verified
- [ ] SQL injection risks assessed
- [ ] CSRF/CORS security reviewed

---

## Performance

- [ ] No performance regressions
- [ ] Bundle size impact assessed (if applicable)
- [ ] Database query efficiency reviewed (if applicable)
- [ ] Memory usage appropriate (if applicable)

---

## Verification Checklist

- [ ] Follows project conventions (see CONVENTIONS.md)
- [ ] Tests pass
- [ ] Linting passes
- [ ] Type checks pass
- [ ] Security scan passes
- [ ] Changes are surgical (no unrelated reformatting)
- [ ] Backward compatibility preserved
- [ ] Documentation updated (if non-trivial)

---

## Reviewer Notes

Any additional context for reviewers.
