# TESTING.md

This file documents testing strategy. See the main copy at [../../doc/TESTING.md](../../doc/TESTING.md).

## Testing Philosophy

Test:
- Behavior
- Contracts
- Regressions
- Business rules

Not implementation details.

## Test Pyramid

### Unit Tests
- Domain logic
- Utilities
- Edge cases

### Integration Tests
- Service boundaries
- Database interaction
- API contracts

### E2E Tests
- Critical user journeys

## CI Rules

PRs must fail if:
- Tests fail
- Lint fails
- Type checks fail
- Security scans fail

**See [../../doc/TESTING.md](../../doc/TESTING.md) for full testing requirements.**
