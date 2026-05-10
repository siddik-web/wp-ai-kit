---
name: Known Issues
description: Documented known issues and workarounds
---

# Known Issues

This file documents known issues, their status, and workarounds.

## Format

```
### Issue Title

**ID**: [GitHub issue #123]
**Status**: Open / In Progress / Resolved / Wontfix
**Severity**: Critical / High / Medium / Low
**Reported**: YYYY-MM-DD
**Last Updated**: YYYY-MM-DD

**Description**: What the issue is

**Impact**: Who/what is affected

**Workaround**: Temporary solution (if available)

**Related**: Links to related issues or discussions

**Root Cause**: Understanding of why this happens (once diagnosed)

**Expected Fix**: When/how this will be resolved
```

---

## Current Issues

(Add documented known issues here as they arise)

---

## Resolved Issues Archive

Issues resolved and no longer applicable:

(Links to resolved issues for historical reference)

---

## When to Add an Issue

Add here when:
- Bug is reproducible but fix is deferred
- There's an important workaround users should know
- Issue affects specific environments only
- Issue is intermittent and hard to diagnose

---

## When to Remove

Remove when:
- Issue is fixed and released
- Issue is no longer applicable
- Superseded by better solution
- Resolution documented in CHANGELOG

---

## Example

### Memory leak on component unmount in Safari

**ID**: #456
**Status**: In Progress
**Severity**: High
**Reported**: 2025-12-15
**Last Updated**: 2025-12-20

**Description**: When SomeComponent unmounts in Safari 15+, memory is not properly released, causing the browser tab to consume increasing memory over time.

**Impact**: Users on Safari 15+ who use the app continuously for >2 hours

**Workaround**: Refresh page every 1-2 hours to reclaim memory. Issue doesn't affect Chrome, Firefox, or Edge.

**Related**: #457, #458 (similar issues reported)

**Root Cause**: useEffect cleanup callback not properly called in Safari when using specific event listener pattern

**Expected Fix**: Refactor event listener cleanup in Q1 2026 as part of larger useEffect audit
