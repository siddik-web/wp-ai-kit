---
name: review
description: Code review with security, architecture, and quality analysis
trigger: "/review"
---

# Review Command

Performs detailed code review focusing on quality, security, architecture, and CLAUDE compliance.

## What It Does

1. **Change analysis**
   - Parse the diff
   - Identify files affected
   - Categorize changes
   - Check for unrelated modifications

2. **Architecture review**
   - Verify layer boundaries
   - Check dependency direction
   - Review composition patterns
   - Identify architectural concerns

3. **Quality review**
   - Logic correctness
   - Edge case handling
   - Error handling appropriateness
   - Code style consistency

4. **Security review**
   - Input validation
   - Authentication/authorization
   - Secret exposure
   - SQL injection risks
   - Permission enforcement

5. **Testing review**
   - Test coverage for changes
   - Test quality assessment
   - Edge cases tested

6. **CLAUDE compliance**
   - Surgical changes check
   - Backward compatibility
   - Reuse before creating
   - Convention adherence

## Output

- Summary of changes
- Issues found (organized by severity)
- Recommendations
- Compliance checklist
- Risk assessment
- Approval recommendation

## Usage

```
@Claude /review
@Claude /review PR-123
@Claude /review commit abc123
```

## Integration

Can be used:
- Before committing
- On open PRs
- On commits
- On branches
