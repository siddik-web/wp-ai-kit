# Contributing to wp-ai-kit

Thank you for your interest in contributing to **wp-ai-kit**! This project is a production-grade engineering starter optimized for AI-assisted development and autonomous coding agents.

By contributing, you agree to follow our code of conduct and development standards.

## Development Philosophy

Before contributing, please read [CLAUDE.md](CLAUDE.md). This document contains our 25 core engineering rules that guide every decision in this project. Our philosophy emphasizes:

1.  **Correctness over speed** — Verify assumptions before implementation.
2.  **Simplicity over cleverness** — Use the minimum code necessary.
3.  **Explicitness over assumptions** — Surface conflicts, name what's unclear.
4.  **Reuse before creating** — Check existing implementations first.
5.  **Surgical changes** — Modify only what's necessary.
6.  **Read before write** — Understand context before modifying code.

If you are an AI agent or using AI tools, please also review [AGENTS.md](AGENTS.md).

## Prerequisites

- **Node.js**: >= 18.0.0
- **npm**: >= 9.0.0
- **Local WordPress Environment**: (e.g., LocalWP, DevKinsta, or Docker-based setup)

## Getting Started

1.  **Fork the repository** on GitHub.
2.  **Clone your fork** locally:
    ```bash
    git clone https://github.com/siddik-web/wp-ai-kit.git
    cd wp-ai-kit
    ```
3.  **Run the setup command**:
    ```bash
    npm run setup:dev
    ```
    This will install dependencies, run linting, and execute tests to ensure your environment is correctly configured.

## Development Workflow

### Standard Commands

- `npm run build`: Build assets using Webpack.
- `npm run start:blocks`: Start development mode for Gutenberg blocks.
- `npm run lint`: Run ESLint and Prettier checks.
- `npm test`: Run the test suite using Jest.
- `npm run typecheck`: Run TypeScript type checks.

### Branching Strategy

- Create a descriptive branch name from `main`.
- Use prefixes: `feature/`, `bugfix/`, `hotfix/`, `docs/`, or `refactor/`.
- Example: `feature/add-new-banner-template`

### Commits

- We follow [Conventional Commits](https://www.conventionalcommits.org/).
- Keep commits small, focused, and descriptive.
- Refer to [Rule 14 in CLAUDE.md](CLAUDE.md#rule-14--keep-diffs-reviewable).

## Coding Standards

Consistency is key. Please adhere to the standards defined in our documentation:

- [Naming and File Structure](doc/CONVENTIONS.md)
- [Architecture Layers](doc/ARCHITECTURE.md)
- [Security Practices](doc/SECURITY.md)

### JavaScript/React
- We use ESLint and Prettier. Run `npm run lint:fix` to auto-format.
- Match the existing style and architectural patterns.

### PHP
- Follow [WordPress Coding Standards (WPCS)](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- Use proper escaping, sanitization, and validation ([Rule 9](CLAUDE.md#rule-9--security-before-convenience)).

## Testing Requirements

Every non-trivial change must include tests. Refer to [doc/TESTING.md](doc/TESTING.md) for our testing philosophy.

- **Unit Tests**: For logic and utility functions.
- **Integration Tests**: For component workflows.
- **E2E Tests**: For critical user paths (using Playwright).

Run `npm test` before submitting your PR.

## Pull Request Process

1.  Ensure all tests and linting pass.
2.  Update documentation if you've introduced new features or changed APIs ([Rule 21](CLAUDE.md#rule-21--documentation-is-part-of-delivery)).
3.  Use the [Pull Request Template](.github/pull_request_template.md).
4.  Ensure your changes are "surgical" and do not include unrelated formatting or code changes ([Rule 5](CLAUDE.md#rule-5--surgical-changes)).
5.  A maintainer will review your PR. Be prepared to discuss your implementation and make adjustments.

## AI-Assisted Contributions

This project explicitly supports AI-assisted workflows. If you are using AI (like GitHub Copilot, Cursor, or Trae):
- Verify all AI output before committing ([Rule 24](CLAUDE.md#rule-24--ai-output-requires-verification)).
- Ensure the AI follows the project-specific instructions in [AGENTS.md](AGENTS.md) and `.claude/`.

---

**Questions?** Open an issue or contact the maintainer. Happy coding!
