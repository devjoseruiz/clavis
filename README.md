# Clavis

Clavis is a web application that allow teachers to manage their classrooms.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/devjoseruiz/clavis.git
   cd clavis
   ```

2. Configure the application:
   - Copy the configuration templates:
     ```bash
     cp app/config/bee_config.php.example app/config/bee_config.php
     cp app/core/settings.php.example app/core/settings.php
     ```
   - Edit both files according to your environment needs

3. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

4. Install PHP dependencies:
   ```bash
   docker-compose exec php composer install
   ```

## Configuration

The application can be configured through two main files:
- `app/config/bee_config.php`: Main application configuration for production use.
- `app/core/settings.php`: Core settings and environment variables.

Make sure to review and adjust these files according to your needs before running the application.

## Usage

After installation, you can access the application through your web browser at `http://localhost:8080`.

## Contributing

Contributions are welcome! Please feel free to submit a pull request.

1. Fork the project.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a pull request.

## License

This project is licensed under the GPLv3 License - see the [LICENSE](LICENSE) file for details.

## Support

If you have any questions or need support, please open an issue in the GitHub repository.