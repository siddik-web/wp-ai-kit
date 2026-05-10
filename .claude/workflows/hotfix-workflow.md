---
name: Hotfix Workflow
description: Expedited workflow for critical hotfixes
---

# Hotfix Workflow

Expedited workflow for critical hotfixes that need immediate deployment.

---

## Hotfix Criteria

Use this workflow **only** for critical bugs where:
- Production is down or severely degraded
- Data integrity is at risk
- Security vulnerability exists
- Performance is unacceptable
- User base significantly affected

For non-critical bugs, use [Bugfix Workflow](bugfix-workflow.md).

---

## Phase 1: Triage (< 15 min)

### 1.1 Immediate Assessment

- [ ] Reproduce bug
- [ ] Confirm severity (critical)
- [ ] Assess user impact
- [ ] Check if workaround exists
- [ ] Identify root cause

### 1.2 Notify Team

- [ ] Alert incident response
- [ ] Notify stakeholders
- [ ] Set up war room if needed
- [ ] Assign fix owner

### 1.3 Create Tracking

- [ ] File incident ticket
- [ ] Link to hotfix branch
- [ ] Set priority to CRITICAL

**Checkpoint**: Hotfix authorized, team assembled

---

## Phase 2: Quick Fix (< 1 hour)

### 2.1 Minimal Test Case

- [ ] Create failing test
- [ ] Confirm bug reproduces
- [ ] Test isolated (not full suite yet)

### 2.2 Implement Fix

- [ ] Fix root cause only
- [ ] Minimal code changes
- [ ] No refactoring
- [ ] No cleanup

### 2.3 Quick Verification

- [ ] Test passes
- [ ] Bug no longer reproducible
- [ ] No obvious new issues

**Checkpoint**: Fix implemented and quick-verified

---

## Phase 3: Expedited Review (< 30 min)

### 3.1 Self-Review

- [ ] Diffs minimal
- [ ] No debug code
- [ ] No unrelated changes

### 3.2 Peer Review

- [ ] Security OK
- [ ] Fix correct
- [ ] No new issues
- [ ] Quick sign-off

**Checkpoint**: Fix approved

---

## Phase 4: Expedited Testing (< 30 min)

### 4.1 Critical Tests Only

- [ ] Fix test passes
- [ ] Related E2E workflows pass
- [ ] No obvious regressions
- [ ] Full suite can be verified after deploy

### 4.2 Staging Quick Check

- [ ] Deploy to staging
- [ ] Verify fix in staging
- [ ] Quick E2E validation
- [ ] No new errors

**Checkpoint**: Staging verified

---

## Phase 5: Hotfix Release (< 30 min)

### 5.1 Version Bump

- [ ] Patch version only: vX.Y.Z+1
- [ ] Minimal changelog entry
- [ ] Brief release notes

### 5.2 Build & Deploy

- [ ] Clean build
- [ ] Artifacts ready
- [ ] Deploy to production
- [ ] Activate monitoring

### 5.3 Immediate Monitoring

- [ ] Error rates decrease
- [ ] Performance improves
- [ ] User reports positive
- [ ] Logs clean
- [ ] No alerts firing

**Checkpoint**: Hotfix deployed, incident resolved

---

## Phase 6: Post-Hotfix (After Crisis)

### 6.1 Comprehensive Testing

- [ ] Run full test suite
- [ ] Run full audit
- [ ] Performance verification
- [ ] Security scan

### 6.2 Root Cause Analysis

- [ ] Why did this happen?
- [ ] Could it have been prevented?
- [ ] How to prevent recurrence?
- [ ] Document findings

### 6.3 Improvement Plan

- [ ] Prevent similar issues
- [ ] Add regression tests
- [ ] Improve monitoring
- [ ] Update runbooks

---

## Total Timeline

- **Triage**: < 15 min
- **Fix**: < 1 hour
- **Review**: < 30 min
- **Testing**: < 30 min
- **Deploy**: < 30 min
- **Total**: ~2.5 hours to production

---

## Deferred Tasks

These are done AFTER hotfix is deployed:

- [ ] Full test suite verification
- [ ] Comprehensive audit
- [ ] Performance baseline check
- [ ] Root cause analysis
- [ ] Prevention measures
- [ ] Update documentation
- [ ] Retrospective

---

## Escalation

If hotfix takes >1 hour to fix, escalate:

- [ ] Call incident response
- [ ] Consider rollback
- [ ] Consider temporary workaround
- [ ] Revert to main/stable
- [ ] Plan fix in background

---

## Document References

- [CLAUDE.md](../../CLAUDE.md) — Engineering rules (adapted for hotfixes)
- [bugfix-workflow.md](bugfix-workflow.md) — Full bugfix process
- [release-workflow.md](release-workflow.md) — Release process

---

## Hotfix Checklist

- [ ] CRITICAL severity confirmed
- [ ] Minimal fix implemented
- [ ] Quick tests pass
- [ ] Peer reviewed
- [ ] Staging verified
- [ ] Version bumped
- [ ] Deployed to production
- [ ] Monitored successfully
- [ ] Post-hotfix review scheduled
