---
name: Feature Development Workflow
description: Step-by-step workflow for developing new features
---

# Feature Development Workflow

Structured workflow for implementing new features from requirements to deployment.

---

## Phase 1: Planning & Analysis

### 1.1 Understand Requirements

- [ ] Read requirements thoroughly
- [ ] Identify ambiguities or contradictions
- [ ] Clarify acceptance criteria
- [ ] Identify user personas affected

**Use**: [Planner Agent](./../agents/planner.md) or `/explain` command

### 1.2 State Assumptions

- [ ] List assumptions explicitly
- [ ] Identify dependencies
- [ ] Highlight constraints
- [ ] Define scope boundaries

### 1.3 Design & Architecture Review

- [ ] Map to existing layers (ARCHITECTURE.md)
- [ ] Identify component interactions
- [ ] Define data flow
- [ ] Check for layer boundary violations
- [ ] Review similar existing patterns

**Use**: Architecture review from [Planner Agent](./../agents/planner.md)

### 1.4 Define Success Criteria

- [ ] Observable success metrics
- [ ] Verification method
- [ ] Test requirements
- [ ] Performance expectations
- [ ] Security requirements

**Checkpoint**: Review plan with team or architect

---

## Phase 2: Implementation

### 2.1 Read Existing Code

- [ ] Find related features
- [ ] Review naming conventions
- [ ] Understand existing patterns
- [ ] Check for reusable components

### 2.2 Create Implementation Plan

- [ ] File structure (by feature, not type)
- [ ] Component breakdown
- [ ] Dependencies identified
- [ ] Phased approach

### 2.3 Implement Incrementally

- [ ] Small commits (one logical change per commit)
- [ ] Follow project conventions
- [ ] Surgical changes only
- [ ] No unrelated reformatting

**Use**: [Builder Agent](./../agents/builder.md)

### 2.4 Test Continuously

- [ ] Unit tests for new logic
- [ ] Integration tests for workflows
- [ ] E2E tests for user journeys
- [ ] All tests passing

**Use**: [Tester Agent](./../agents/tester.md) or `/test` command

### 2.5 Security Review

- [ ] Input validation present
- [ ] No raw SQL or secrets
- [ ] Permissions enforced
- [ ] Authorization verified

**Use**: [Security Agent](./../agents/security.md)

**Checkpoint**: Code review ready

---

## Phase 3: Code Review

### 3.1 Self-Review

- [ ] Diffs are reviewable
- [ ] Changes are surgical
- [ ] No temporary debugging code
- [ ] Backward compatible

### 3.2 Peer Review

- [ ] Architecture compliance
- [ ] Style and conventions
- [ ] Test coverage
- [ ] Security checks
- [ ] Performance OK

**Use**: [Reviewer Agent](./../agents/reviewer.md) or `/review` command

### 3.3 Address Feedback

- [ ] Update based on comments
- [ ] Re-run tests
- [ ] Request re-review if substantial changes

**Checkpoint**: Code review approved

---

## Phase 4: Integration & Testing

### 4.1 Merge to Main

- [ ] All CI checks pass
- [ ] Tests still passing
- [ ] No conflicts

### 4.2 Verify in Integration

- [ ] Feature works in integrated environment
- [ ] No regressions
- [ ] Performance acceptable
- [ ] No new errors in logs

### 4.3 Staging Deployment

- [ ] Deploy to staging
- [ ] E2E testing in staging
- [ ] Performance monitoring
- [ ] Security scanning

---

## Phase 5: Deployment & Monitoring

### 5.1 Prepare Release

- [ ] Version bump (semantic)
- [ ] Changelog updated
- [ ] Release notes prepared
- [ ] Migration guide (if needed)

**Use**: `/release` command

### 5.2 Production Deployment

- [ ] Final verification
- [ ] Deployment process
- [ ] Monitoring active
- [ ] Rollback plan ready

### 5.3 Post-Deployment

- [ ] Monitor metrics
- [ ] Check logs for errors
- [ ] Gather user feedback
- [ ] Document any issues

---

## Checkpoints & Reviews

| Phase | Checkpoint | Reviewer |
|-------|-----------|----------|
| 1 | Plan approved | Architect / Lead |
| 2 | Code review ready | Self-review |
| 3 | Code approved | Peer / Reviewer |
| 4 | Staging verified | QA / Product |
| 5 | Production ready | Release Manager |

---

## Command Quick Reference

```
@Claude /audit              # Comprehensive code audit
@Claude /test               # Run all tests
@Claude /review             # Code review
@Claude /explain [code]     # Explain design
@Claude /refactor [target]  # Safe refactoring
@Claude /fix                # Fix issues
@Claude /release            # Prepare release
```

---

## Document References

- [CLAUDE.md](../../CLAUDE.md) — Engineering rules
- [ARCHITECTURE.md](../context/ARCHITECTURE.md) — System design
- [CONVENTIONS.md](../context/CONVENTIONS.md) — Naming and style
- [TESTING.md](../context/TESTING.md) — Testing strategy
- [SECURITY.md](../context/SECURITY.md) — Security requirements
