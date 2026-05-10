---
name: fix
description: Automatically fix linting, formatting, or security issues
trigger: "/fix"
---

# Fix Command

Automatically fixes common issues like linting, formatting, or security problems.

## What It Does

1. **Linting fixes**
   - Run linter with auto-fix
   - Fix unused imports
   - Fix formatting violations

2. **Security fixes**
   - Add input validation
   - Fix SQL injection vulnerabilities
   - Add missing permission checks
   - Fix credential exposure in logs

3. **Performance fixes**
   - Fix obvious inefficiencies
   - Add pagination where missing
   - Optimize imports
   - Remove dead code

4. **Type safety fixes**
   - Add missing type annotations
   - Fix type errors
   - Add null checks

5. **Convention fixes**
   - Rename for consistency
   - Fix file structure issues
   - Standardize comment style

## Output

- Files modified with explanations
- Before/after diffs
- Verification results
- Any manual fixes still needed

## Usage

```
@Claude /fix
```

Optionally specify:
```
@Claude /fix linting
@Claude /fix security
@Claude /fix performance
@Claude /fix types
```

## Verification

Automatically runs:
- Linting
- Type checking
- Tests
- Security scan (if available)

Manual verification recommended before committing.
