# Testing Strategy

## Philosophy

Test:
- behavior
- contracts
- regressions
- business rules

Not implementation details.

---

## Test Pyramid

### Unit Tests

Focus:
- domain logic
- utilities
- edge cases

Requirements:
- deterministic
- isolated
- fast

---

### Integration Tests

Focus:
- service boundaries
- database interaction
- API contracts

---

### E2E Tests

Focus:
- critical user journeys

Examples:
- checkout
- authentication
- publishing
- payments

---

## Required Coverage

Critical business logic:
- required

UI snapshots:
- optional

Coverage % is not success.
Behavior verification is success.

---

## Accessibility Testing

Required:
- keyboard navigation
- focus handling
- semantic landmarks

---

## Performance Testing

Track:
- LCP
- CLS
- TTFB
- bundle size

Prevent regressions in CI.

---

## CI Rules

PRs must fail if:
- tests fail
- lint fails
- type checks fail
- security scans fail