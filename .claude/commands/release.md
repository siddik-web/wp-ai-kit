---
name: release
description: Prepare and validate release with version bump, changelog, and verification
trigger: "/release"
---

# Release Command

Prepares a production release including version bump, changelog, and comprehensive verification.

## What It Does

1. **Version determination**
   - Analyze commits since last release
   - Suggest semantic version
   - Validate breaking changes documented

2. **Changelog generation**
   - Summarize changes (features, fixes, breaking changes)
   - Group by category
   - Reference related issues/PRs
   - Follow RELEASE.md format

3. **Verification**
   - All tests pass
   - Linting passes
   - Type checking passes
   - Security scan passes
   - No security vulnerabilities
   - Performance baselines met

4. **Documentation review**
   - README updated if needed
   - CHANGELOG complete
   - Migration guides if breaking changes
   - Release notes prepared

5. **Deployment readiness**
   - Build succeeds
   - No uncommitted changes
   - Clean state verified
   - Release branch created if needed

## Output

- Proposed version
- Changelog
- Migration guide (if applicable)
- Release notes
- Verification results
- Next steps

## Usage

```
@Claude /release
@Claude /release major
@Claude /release minor
@Claude /release patch
```

## Verification Checklist

- [ ] Tests pass
- [ ] Linting passes
- [ ] Type checks pass
- [ ] Security scan passes
- [ ] No vulnerabilities
- [ ] Performance OK
- [ ] Documentation complete
- [ ] Build succeeds
- [ ] No uncommitted changes

See [RELEASE.md](../../doc/RELEASE.md) for full release procedures.
