# Contributing to Laravel User Auth Blog

First off, thank you for considering contributing to Laravel User Auth Blog! 🎉

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues. When you create a bug report, include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples**
- **Describe the behavior you observed and what you expected**
- **Include screenshots if relevant**
- **Include your environment details** (OS, PHP version, Laravel version)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion:

- **Use a clear and descriptive title**
- **Provide a detailed description** of the suggested enhancement
- **Explain why this enhancement would be useful**
- **List some examples** of how it would be used

### Pull Requests

1. Fork the repo and create your branch from `main`
2. If you've added code that should be tested, add tests
3. Update the documentation if needed (see [docs/](docs/))
4. Follow the code style guidelines (use Laravel Pint: `./vendor/bin/pint`)
5. Write clear commit messages following [Conventional Commits](https://www.conventionalcommits.org/)
6. Ensure all tests pass (`php artisan test`)
3. If you've changed APIs, update the documentation
4. Ensure the test suite passes
5. Make sure your code follows Laravel coding standards (use Laravel Pint)
6. Write a clear commit message following Conventional Commits

#### Commit Convention

We follow [Conventional Commits](https://www.conventionalcommits.org/):

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: A new feature
- `fix`: A bug fix
- `docs`: Documentation only changes
- `style`: Changes that don't affect code meaning (formatting, etc.)
- `refactor`: Code change that neither fixes a bug nor adds a feature
- `perf`: Performance improvement
- `test`: Adding or correcting tests
- `chore`: Changes to build process or auxiliary tools

**Examples:**
```
feat(posts): add post scheduling functionality
fix(auth): resolve login redirect issue
docs(readme): update installation instructions
test(posts): add post creation test cases
```

### Code Style

This project follows Laravel coding standards:

- Run `./vendor/bin/pint` before committing to format your code
- Follow PSR-12 coding standard
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

### Development Setup

1. Clone your fork:
```bash
git clone https://github.com/your-username/laravel-user-auth-blog.git
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

4. Run tests to make sure everything works:
```bash
php artisan test
```

### Testing

- Write tests for new features
- Update tests when fixing bugs
- Run the full test suite before submitting PR: `php artisan test`
- Aim for good test coverage

### Documentation

- Update README.md if you change functionality
- Update API.md if you change routes or API
- Update DATABASE.md if you change database schema
- Add inline documentation for complex code

## Code of Conduct

### Our Pledge

We pledge to make participation in our project a harassment-free experience for everyone.

### Our Standards

Examples of behavior that contributes to a positive environment:

- Using welcoming and inclusive language
- Being respectful of differing viewpoints
- Gracefully accepting constructive criticism
- Focusing on what is best for the community
- Showing empathy towards other community members

Examples of unacceptable behavior:

- Trolling, insulting/derogatory comments, and personal attacks
- Public or private harassment
- Publishing others' private information without permission
- Other conduct which could reasonably be considered inappropriate

## Questions?

Feel free to open an issue with your question or contact the maintainers directly.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
