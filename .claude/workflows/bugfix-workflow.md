---
name: Bugfix Development Workflow
description: Workflow for identifying, fixing, and deploying bug fixes
---

# Bugfix Development Workflow

Structured workflow for identifying, reproducing, fixing, and deploying bug fixes.

---

## Phase 1: Triage & Investigation

### 1.1 Collect Information

- [ ] Bug report details collected
- [ ] Severity assessed (critical/high/medium/low)
- [ ] Reproducibility confirmed
- [ ] Environment documented

### 1.2 Reproduce the Bug

- [ ] Reproduce consistently
- [ ] Isolate conditions
- [ ] Identify frequency (always/intermittent)
- [ ] Check if regression or existing issue

### 1.3 Analyze Root Cause

- [ ] Review relevant code
- [ ] Check error logs
- [ ] Trace execution path
- [ ] Identify affected components
- [ ] Check if security issue

**Use**: [Planner Agent](./../agents/planner.md) or `/explain` command

### 1.4 Assess Impact

- [ ] How many users affected?
- [ ] Data integrity risk?
- [ ] Security risk?
- [ ] Performance impact?
- [ ] Workaround available?

**Checkpoint**: Triage complete, fix approach decided

---

## Phase 2: Fix Implementation

### 2.1 Create Test Case

- [ ] Write failing test that reproduces bug
- [ ] Test confirms the bug
- [ ] Test will verify the fix

**Use**: [Tester Agent](./../agents/tester.md)

### 2.2 Implement Fix

- [ ] Fix root cause (not symptom)
- [ ] Minimal changes necessary
- [ ] Don't introduce new issues
- [ ] Follow project conventions

**Use**: [Builder Agent](./../agents/builder.md)

### 2.3 Verify Fix

- [ ] Test now passes
- [ ] Bug no longer reproducible
- [ ] No regressions
- [ ] Edge cases handled

### 2.4 Security Review

- [ ] Fix doesn't introduce vulnerabilities
- [ ] Input validation still present
- [ ] Permissions still enforced
- [ ] No new security risks

**Use**: [Security Agent](./../agents/security.md)

**Checkpoint**: Fix implemented and tested

---

## Phase 3: Code Review

### 3.1 Self-Review

- [ ] Only necessary changes included
- [ ] No debug code left
- [ ] Tests comprehensive
- [ ] Fix is minimal

### 3.2 Peer Review

- [ ] Root cause fixed, not symptom
- [ ] No new issues introduced
- [ ] Test coverage adequate
- [ ] Security verified
- [ ] Performance OK

**Use**: [Reviewer Agent](./../agents/reviewer.md) or `/review` command

### 3.3 Address Feedback

- [ ] Update based on comments
- [ ] Re-run all tests
- [ ] Request re-review if needed

**Checkpoint**: Code review approved

---

## Phase 4: Integration & Testing

### 4.1 Test in Main

- [ ] All CI checks pass
- [ ] All tests still passing
- [ ] No conflicts with main branch

### 4.2 Regression Testing

- [ ] Similar bugs checked
- [ ] Related features tested
- [ ] No new issues observed

### 4.3 Staging Deployment

- [ ] Deploy to staging
- [ ] Verify fix in staging
- [ ] Verify no side effects
- [ ] Performance OK

---

## Phase 5: Deployment & Monitoring

### 5.1 Hotfix or Scheduled Release?

**Critical bugs**: Deploy as hotfix immediately
**Non-critical**: Include in next scheduled release

### 5.2 Prepare Release

- [ ] Version bump (patch for hotfix)
- [ ] Changelog note
- [ ] Release notes

### 5.3 Production Deployment

- [ ] Deploy fix
- [ ] Immediate monitoring
- [ ] Alert thresholds set
- [ ] Rollback plan ready

### 5.4 Post-Deployment

- [ ] Monitor error rates
- [ ] Check logs
- [ ] Verify fix effective
- [ ] Gather feedback
- [ ] Update documentation if needed

---

## Bug Severity & Response Time

| Severity | Response | Fix Target | Deploy Target |
|----------|----------|-----------|---------------|
| Critical | Immediate | < 1 hour | ASAP (hotfix) |
| High | < 4 hours | < 8 hours | Next day |
| Medium | < 24 hours | < 48 hours | Next release |
| Low | Next sprint | Backlog | Next release |

---

## Command Quick Reference

```
@Claude /explain [bug]      # Understand the bug
@Claude /test               # Run tests
@Claude /audit              # Check for related issues
@Claude /review             # Code review
@Claude /fix                # Fix common issues
@Claude /release            # Prepare hotfix release
```

---

## Document References

- [CLAUDE.md](../../CLAUDE.md) — Engineering rules
- [ARCHITECTURE.md](../context/ARCHITECTURE.md) — System design
- [TESTING.md](../context/TESTING.md) — Testing strategy
- [templates/bug-report.md](../templates/bug-report.md) — Bug report template
