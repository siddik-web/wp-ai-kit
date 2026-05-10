---
name: test
description: Run tests and provide coverage analysis with gaps
trigger: "/test"
---

# Test Command

Runs tests, analyzes coverage, and identifies gaps.

## What It Does

1. **Test execution**
   - Run unit tests
   - Run integration tests
   - Run E2E tests
   - Report failures

2. **Coverage analysis**
   - Line coverage
   - Branch coverage
   - Function coverage
   - Identify uncovered code

3. **Gap identification**
   - Critical business logic uncovered
   - Error paths untested
   - Edge cases missing
   - Accessibility gaps

4. **Performance baseline**
   - Test execution time
   - Performance regression detection
   - Slow test identification

5. **Quality assessment**
   - Test quality (not just coverage %)
   - Mock usage appropriateness
   - Test maintainability

## Output

- Test results (pass/fail)
- Coverage summary
- Failed tests with details
- Coverage gaps identified
- Recommendations for new tests
- Performance baseline

## Usage

```
@Claude /test
@Claude /test unit
@Claude /test integration
@Claude /test e2e
@Claude /test coverage
```

## Verification

Tests must verify:
- Business logic correctness
- Error handling
- Edge cases
- Integration points
- User workflows (E2E)
- Performance expectations
- Accessibility (where applicable)

See [TESTING.md](../../doc/TESTING.md) for testing philosophy and requirements.
