# Architecture

## Principles

1. Simplicity over abstraction
2. Explicitness over magic
3. Composition over inheritance
4. Stability over novelty
5. Server-first where possible

---

## Layers

### UI Layer

Responsibilities:
- rendering
- accessibility
- interaction

Must NOT:
- fetch directly from DB
- contain business logic
- mutate global state arbitrarily

---

### Application Layer

Responsibilities:
- workflows
- orchestration
- validation
- business rules

Must remain framework-light.

---

### Domain Layer

Responsibilities:
- core business logic
- invariant enforcement
- shared domain rules

Must NOT:
- depend on UI
- depend on transport layers

---

### Infrastructure Layer

Responsibilities:
- APIs
- database
- caching
- filesystem
- external integrations

Must be replaceable.

---

## Data Flow

UI
→ Application
→ Domain
→ Infrastructure

Never reverse this flow.

---

## State Strategy

Prefer:
- local state
- server state
- explicit state ownership

Avoid:
- unnecessary global state
- hidden mutations
- implicit shared stores

---

## Performance Philosophy

Optimize:
- largest bottlenecks first
- user-visible latency first

Measure before major optimization.

---

## Accessibility

Accessibility is mandatory.

Minimum:
- keyboard navigation
- semantic HTML
- color contrast
- screen reader compatibility
- focus management

---

## Internationalization

All user-facing strings:
- translatable
- centralized
- context-aware

No hardcoded strings in components.