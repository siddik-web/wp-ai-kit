---
name: Migration History
description: Record of past breaking changes and migrations
---

# Migration History

Record of past breaking changes, migrations, and deprecation notices.

This helps prevent similar mistakes and documents how we've evolved.

---

## Format

```
## Version X.Y.Z → X.Y.Z+1

**Release Date**: YYYY-MM-DD
**Type**: Major / Minor / Patch breaking change
**Impact**: Who this affects, severity

### Breaking Change: [Name]

**What Changed**: Clear description

**Why**: Rationale for the change

**Before** (Old Way):
\`\`\`code
\`\`\`

**After** (New Way):
\`\`\`code
\`\`\`

**Migration Steps**:
1. Step 1
2. Step 2

**Timeline**: Deprecation warning introduced in X.Y.0, breaking change in X+1.0.0

### Related Issues
- #123 — Issue that prompted change
- #456 — Related discussion
```

---

## Migration Records

(Add migration records here as breaking changes occur)

---

## Example

## Version 1.1.0 → 2.0.0

**Release Date**: 2026-06-15
**Type**: Major breaking change
**Impact**: All users; requires code updates before upgrading

### Breaking Change: Refactored Authentication API

**What Changed**: Authentication function signatures and workflow changed

**Why**: Old API was error-prone; new API is more type-safe and supports multiple auth methods

**Before** (Old Way):
```js
const token = auth.login(email, password);
if (!token) {
  // Auth failed, but no indication why
}
auth.setToken(token);
```

**After** (New Way):
```js
try {
  const { user, token } = await auth.authenticate({
    method: 'email',
    credentials: { email, password }
  });
  auth.setSession({ user, token });
} catch (error) {
  // Clear error: InvalidCredentials | NetworkError | etc
  handleAuthError(error);
}
```

**Migration Steps**:
1. Update all `auth.login()` calls to `auth.authenticate()`
2. Update error handling to use new error types
3. Update `auth.setToken()` calls to `auth.setSession()`
4. Run test suite
5. Deploy and monitor

**Timeline**: 
- Deprecation warning in 1.5.0
- Old API worked but showed warnings in console
- Breaking change in 2.0.0

### Related Issues
- #890 — Authentication refactor ADR
- #891 — Error handling improvement
- #892 — Security audit findings

---

## Deprecation Timeline

This section tracks active deprecation notices:

### Currently Deprecated

- `auth.login()` — Use `auth.authenticate()` instead (deprecated since 1.5.0, removal in 3.0.0)

### Recently Removed

- `legacyFormat()` — Removed in 2.0.0, use `newFormat()` instead

---

## How We Avoid Breaking Changes

1. **Carefully review API changes** before locking in
2. **Add deprecation warnings** before breaking changes
3. **Provide migration guides** for every breaking change
4. **Give 2+ minor versions notice** (when possible)
5. **Document in CHANGELOG** clearly
6. **Update examples and docs** before release

---

## Reference

- [RELEASE.md](../../doc/RELEASE.md) — Release procedures
- [DECISIONS.md](../context/DECISIONS.md) — Architectural decisions
- [CLAUDE.md Rule 8](../../CLAUDE.md#rule-8--preserve-backward-compatibility) — Backward compatibility principle

---

## When to Add

Add migration records when:
- New major version released
- Breaking changes introduced
- Deprecation notice added
- Migration guide created
- Large API refactoring completed
