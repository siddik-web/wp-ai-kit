# ARCHITECTURE.md

This file documents system architecture. See the main copy at [../../doc/ARCHITECTURE.md](../../doc/ARCHITECTURE.md).

For quick reference in this context folder, key architecture principles:

## Layers

- **UI Layer**: Rendering, accessibility, interaction only
- **Application Layer**: Workflows, orchestration, validation
- **Domain Layer**: Core business logic, independent of transport/UI

## Core Principles

1. Simplicity over abstraction
2. Explicitness over magic
3. Composition over inheritance
4. Stability over novelty
5. Server-first where possible

**See [../../doc/ARCHITECTURE.md](../../doc/ARCHITECTURE.md) for full details.**
