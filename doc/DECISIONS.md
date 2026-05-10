# Architecture Decisions

Document important engineering decisions.

---

# ADR-001

## Title

Use server-first rendering by default

## Status

Accepted

## Context

Client-heavy rendering increases:
- JS payload
- hydration cost
- runtime complexity

## Decision

Prefer server rendering unless interactivity requires client execution.

## Consequences

Pros:
- faster initial render
- better SEO
- smaller bundles

Cons:
- more server coordination
- hydration boundaries required

---

# ADR-002

## Title

Single source of truth for API contracts

## Status

Accepted

## Context

Duplicate types drift over time.

## Decision

Generate shared types from canonical schemas.

## Consequences

Pros:
- consistency
- safer refactors

Cons:
- tooling complexity