---
name: audit
description: Comprehensive code audit for quality, security, and architecture
trigger: "/audit"
---

# Audit Command

Performs a comprehensive audit of code quality, security posture, and architectural compliance.

## What It Does

1. **Architecture audit**
   - Verify layer boundaries
   - Check for layer violations
   - Identify inappropriate dependencies
   - Review composition patterns

2. **Quality audit**
   - Check for code smells
   - Identify dead code
   - Review error handling
   - Check for overly complex functions

3. **Security audit**
   - Input validation scan
   - Credential exposure check
   - Permission enforcement review
   - SQL injection vulnerability scan
   - Dependency vulnerability check

4. **Performance audit**
   - Identify N+1 queries
   - Check for unnecessary re-renders
   - Review bundle size
   - Identify performance antipatterns

5. **Convention audit**
   - Naming consistency
   - File structure adherence
   - Comment style
   - Testing coverage

## Output

- Issues found (organized by category)
- Severity level for each issue
- Suggested fixes
- Quick wins vs. long-term refactoring
- Overall health score

## Usage

```
@Claude /audit
```

Optionally scope:
```
@Claude /audit frontend
@Claude /audit src/auth
@Claude /audit database
```
