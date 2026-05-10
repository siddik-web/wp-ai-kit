# CLAUDE.md

These rules apply to every task in this project unless explicitly overridden.

Bias:
- correctness over speed
- simplicity over cleverness
- explicitness over assumptions
- maintainability over novelty

The goal is production-safe engineering with minimal drift.

---

# Rule 1 — Think Before Coding

State assumptions explicitly before implementation.

If requirements are ambiguous:
- present possible interpretations
- identify tradeoffs
- ask clarifying questions when necessary

Do not guess hidden requirements.

Push back when:
- a simpler solution exists
- complexity is unnecessary
- requested architecture does not match scope

Stop when confused.
Name exactly what is unclear.

---

# Rule 2 — Read Before You Write

Before modifying code:
- read related files
- read exports/imports
- read immediate callers
- inspect shared utilities
- understand surrounding conventions

Do not assume code is isolated.

If structure seems unusual:
- identify why it may exist
- ask before replacing patterns

Never rewrite blindly.

---

# Rule 3 — Reuse Before Creating

Before adding:
- utilities
- hooks
- services
- components
- helpers
- configs

Search for existing implementations first.

Prefer:
- extension
- composition
- adaptation

Avoid:
- duplicate utilities
- parallel abstractions
- near-identical helpers

If replacing an existing pattern:
- explain why
- identify migration impact

---

# Rule 4 — Simplicity First

Write the minimum code necessary.

Avoid:
- speculative abstractions
- premature optimization
- generic systems for one use case
- unnecessary indirection
- future-proofing without evidence

Every abstraction must justify itself.

Ask:
"Would a senior engineer consider this simpler?"

If not:
- reduce scope
- reduce layers
- reduce moving parts

---

# Rule 5 — Surgical Changes

Modify only what is necessary.

Do not:
- reformat unrelated code
- rename unrelated symbols
- reorganize files unnecessarily
- refactor adjacent systems without cause

Clean up:
- only what your change directly affects
- only what improves correctness/readability locally

Match existing style unless instructed otherwise.

---

# Rule 6 — Define Success Before Execution

Before implementation define:
- observable success criteria
- verification method
- scope boundaries
- non-goals

Do not confuse:
- activity with progress
- code written with correctness
- passing compilation with completion

Working, verified behavior is completion.

---

# Rule 7 — Match Codebase Conventions

Inside a repository:
- convention consistency beats personal preference

Follow existing:
- naming
- structure
- typing style
- architecture patterns
- test organization
- formatting conventions

If a convention appears harmful:
- surface concern explicitly
- do not silently fork patterns

---

# Rule 8 — Preserve Backward Compatibility

Do not silently break:
- public APIs
- hooks
- filters
- database schemas
- block attributes
- CSS contracts
- stored content
- serialized data
- URLs/routes

When breaking changes are necessary:
- state them explicitly
- explain impact
- provide migration guidance
- isolate blast radius

---

# Rule 9 — Security Before Convenience

Treat all input as untrusted.

Always:
- validate input
- sanitize data
- escape output contextually
- enforce permissions
- verify authorization
- use prepared statements
- protect secrets

Never:
- trust client input
- interpolate raw SQL
- expose credentials
- bypass capability checks
- disable CSRF/nonces casually
- leak sensitive logs

Security issues block completion.

---

# Rule 10 — Performance By Default

Prefer:
- predictable complexity
- efficient queries
- batching
- caching where justified
- lazy loading
- streaming large workloads
- avoiding unnecessary renders

Avoid:
- repeated scans
- N+1 queries
- unnecessary allocations
- expensive synchronous work
- excessive client-side computation

Do not optimize blindly.
Do not ignore obvious inefficiencies.

Measure before deep optimization.

---

# Rule 11 — Accessibility Is Required

All UI work must consider:
- keyboard navigation
- semantic HTML
- focus management
- contrast
- screen reader support
- reduced motion preferences
- responsive behavior

Do not treat accessibility as enhancement work.

Accessibility regressions are bugs.

---

# Rule 12 — Tests Verify Intent

Tests should encode:
- business intent
- behavioral guarantees
- regression protection

Avoid tests that:
- mirror implementation details
- cannot fail meaningfully
- break during harmless refactors

Prefer:
- integration tests for workflows
- unit tests for logic
- end-to-end tests for critical paths

A test should explain WHY behavior matters.

---

# Rule 13 — Make Failures Diagnosable

Errors must contain actionable context.

Prefer:
- explicit failures
- structured logging
- deterministic behavior
- meaningful error messages
- observable state transitions

Avoid:
- swallowed exceptions
- silent retries
- hidden fallback behavior
- ambiguous states

If something fails:
- make root-cause discovery easier

---

# Rule 14 — Keep Diffs Reviewable

Prefer:
- small commits
- isolated concerns
- incremental changes

Avoid:
- mixed-purpose diffs
- broad rewrites
- unrelated formatting
- unnecessary renames

A reviewer should understand:
- what changed
- why it changed
- risk level
within minutes.

---

# Rule 15 — Surface Conflicts Explicitly

When patterns conflict:
- identify the conflict
- explain tradeoffs
- choose intentionally

Do not:
- merge incompatible patterns silently
- average contradictory approaches

Prefer:
- the more established pattern
- the more tested pattern
- the less risky pattern

Flag inconsistencies for future cleanup.

---

# Rule 16 — Fail Loud

Never claim:
- "done"
- "fixed"
- "tested"
- "production ready"

unless verified.

Explicitly state:
- what was verified
- what was not verified
- what assumptions remain
- what risks remain

Skipped work must be surfaced explicitly.

---

# Rule 17 — Use AI For Judgment, Not Determinism

Use AI for:
- reasoning
- summarization
- drafting
- classification
- architecture discussion
- tradeoff analysis

Prefer code/system solutions for:
- deterministic transforms
- validation
- routing
- retries
- exact calculations
- repetitive workflows

If software can reliably answer:
software should answer.

---

# Rule 18 — Respect Token Budgets

Per-task budget:
- 4k tokens target

Per-session budget:
- 30k tokens target

When approaching limits:
- summarize progress
- preserve state
- propose continuation strategy

Do not silently degrade reasoning quality.

---

# Rule 19 — Checkpoint Frequently

After significant steps:
- summarize completed work
- summarize verified behavior
- identify remaining work
- identify unresolved risks

Never continue from:
- unclear state
- uncertain assumptions
- unverified foundations

If context becomes confusing:
stop and restate.

---

# Rule 20 — Never Invent System Knowledge

Never assume:
- files exist
- APIs exist
- packages exist
- env vars exist
- framework capabilities exist
- database fields exist
- configs exist
- infrastructure exists

Verify from:
- source code
- documentation
- runtime inspection

If verification is impossible:
say so explicitly.

---

# Rule 21 — Documentation Is Part Of Delivery

Non-trivial changes must include:
- usage notes
- setup instructions
- migration notes
- operational implications
- testing guidance

Code without operational context is incomplete.

---

# Rule 22 — Production Stability Over Perfection

Prefer:
- reliable solutions
- understandable solutions
- maintainable solutions

Avoid:
- architecture astronautics
- trendy complexity
- unnecessary rewrites

Stable and boring is often correct.

---

# Rule 23 — Explicit Dependency Discipline

Before adding dependencies:
- verify necessity
- evaluate maintenance quality
- evaluate bundle/runtime impact
- check existing ecosystem usage

Prefer:
- platform capabilities
- existing dependencies
- smaller surface area

Every dependency adds:
- maintenance cost
- security risk
- upgrade burden

---

# Rule 24 — AI Output Requires Verification

AI-generated code is untrusted until verified.

Always validate:
- correctness
- security
- performance implications
- edge cases
- framework compatibility

Never merge unreviewed AI output blindly.

---

# Rule 25 — Optimize For Long-Term Maintainability

Prioritize:
- readability
- debuggability
- operational clarity
- predictable behavior

Future engineers should be able to:
- understand intent quickly
- modify safely
- debug confidently

Code is maintained longer than it is written.