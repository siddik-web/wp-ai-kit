---
name: Release Workflow
description: Workflow for preparing and executing production releases
---

# Release Workflow

Structured workflow for preparing and executing production releases.

---

## Phase 1: Release Preparation

### 1.1 Determine Release Scope

- [ ] Review merged PRs since last release
- [ ] Categorize by type: features, fixes, breaking changes
- [ ] Identify what's included
- [ ] Skip what's not ready

### 1.2 Determine Version

- [ ] Analyze commit types
- [ ] Check for breaking changes
- [ ] Apply semantic versioning:
  - MAJOR: Breaking changes
  - MINOR: New features (backward compatible)
  - PATCH: Bug fixes only

### 1.3 Migration & Compatibility Check

- [ ] Any breaking changes?
- [ ] Migration guide needed?
- [ ] Deprecation notices needed?
- [ ] Backward compatibility preserved?

**Use**: [Planner Agent](./../agents/planner.md)

### 1.4 Documentation Audit

- [ ] README updated?
- [ ] API docs updated?
- [ ] Integration guides updated?
- [ ] ARCHITECTURE changes documented?

**Checkpoint**: Release scope and version decided

---

## Phase 2: Release Preparation (Technical)

### 2.1 Update CHANGELOG

- [ ] Features documented
- [ ] Bug fixes documented
- [ ] Breaking changes highlighted
- [ ] Dependencies updated
- [ ] Contributors listed

**Use**: `/release` command or use [template](../templates/release-notes.md)

### 2.2 Update Documentation

- [ ] Release notes complete
- [ ] Migration guides written (if breaking)
- [ ] API docs current
- [ ] Examples updated
- [ ] Installation instructions current

### 2.3 Version Bump

- [ ] package.json version updated
- [ ] Other version files updated
- [ ] Build metadata updated

### 2.4 Final Code Review

- [ ] No debugging code
- [ ] No temporary changes
- [ ] All commits relevant to release
- [ ] Diffs are clean

**Use**: [Reviewer Agent](./../agents/reviewer.md) or `/review` command

**Checkpoint**: Documentation complete, version bumped

---

## Phase 3: Release Verification

### 3.1 Run Full Test Suite

- [ ] Unit tests pass
- [ ] Integration tests pass
- [ ] E2E tests pass
- [ ] Performance tests pass
- [ ] All coverage requirements met

**Use**: `/test` command

### 3.2 Comprehensive Audit

- [ ] Code quality audit passes
- [ ] Security scan passes
- [ ] No vulnerabilities
- [ ] Performance baselines met
- [ ] No breaking changes without migration guide

**Use**: `/audit` command

### 3.3 Build Verification

- [ ] Clean build succeeds
- [ ] All assets generated
- [ ] Bundle size acceptable
- [ ] Tree-shaking works
- [ ] Minification correct

### 3.4 Dependency Check

- [ ] No new vulnerabilities in dependencies
- [ ] Dependency licenses acceptable
- [ ] No deprecated versions

**Checkpoint**: All verification passes

---

## Phase 4: Release Execution

### 4.1 Tag & Commit

- [ ] Commit version bump + changelog
- [ ] Tag with semantic version: `v1.2.3`
- [ ] Tag message includes release notes summary

### 4.2 Build Release Artifacts

- [ ] Build succeeds
- [ ] Artifacts generated
- [ ] Checksums computed
- [ ] Source maps included (if applicable)

### 4.3 Generate Release Notes

- [ ] Final release notes prepared
- [ ] Changelog complete
- [ ] Migration guides attached
- [ ] Contributors credited

### 4.4 Pre-Production Verification

- [ ] Staging deployment succeeds
- [ ] All E2E tests pass in staging
- [ ] Performance verified
- [ ] Logs clean

**Checkpoint**: Ready for production

---

## Phase 5: Production Deployment

### 5.1 Deploy Release

- [ ] Follow deployment procedure
- [ ] Monitoring active
- [ ] Alert thresholds set
- [ ] Rollback plan ready

### 5.2 Immediate Monitoring (First Hour)

- [ ] Error rates normal
- [ ] Performance normal
- [ ] No reported issues
- [ ] Logs clean

### 5.3 Extended Monitoring (24 Hours)

- [ ] Error rates stable
- [ ] Performance metrics normal
- [ ] User feedback positive
- [ ] No data integrity issues

### 5.4 Announce Release

- [ ] Release notes published
- [ ] Changelog available
- [ ] Migration guide linked
- [ ] Team notified

---

## Phase 6: Post-Release

### 6.1 Gather Feedback

- [ ] Monitor support channels
- [ ] Review error reports
- [ ] Assess user feedback
- [ ] Identify hot issues

### 6.2 Update Documentation

- [ ] Link to release notes
- [ ] Update version info
- [ ] Update download links
- [ ] Update examples

### 6.3 Plan Next Release

- [ ] Review backlog
- [ ] Identify next items
- [ ] Plan next version

---

## Release Checklist

### Before Release
- [ ] Version determined
- [ ] Changelog updated
- [ ] Migration guides written
- [ ] Documentation complete
- [ ] Tests passing
- [ ] Security audit passed
- [ ] Staging verified
- [ ] No uncommitted changes

### During Release
- [ ] Version bumped
- [ ] Build succeeds
- [ ] Artifacts generated
- [ ] Release notes published
- [ ] Monitoring active

### After Release
- [ ] Production stable
- [ ] Feedback collected
- [ ] Documentation updated
- [ ] Next release planned

---

## Rollback Plan

If critical issues discovered post-release:

1. [ ] Identify issue severity
2. [ ] Assess rollback risk
3. [ ] Execute rollback if necessary
4. [ ] Document what went wrong
5. [ ] Plan fix and re-release

---

## Command Quick Reference

```
@Claude /release            # Prepare release
@Claude /test               # Run all tests
@Claude /audit              # Final verification
@Claude /review             # Code review
```

---

## Document References

- [CLAUDE.md](../../CLAUDE.md) — Engineering rules
- [doc/RELEASE.md](../../doc/RELEASE.md) — Release procedures
- [templates/release-notes.md](../templates/release-notes.md) — Release notes template
