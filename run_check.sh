#!/bin/bash

echo "Choose an option:"
echo "1) Run style check"
echo "2) Run tests"
echo "3) Run both style check and tests"
read -p "Enter your choice [1-3]: " choice

case $choice in
    1)
        echo "Running style check..."
        ./vendor/bin/pint -v
        ;;
    2)
        echo "Running tests..."
        ./vendor/bin/pest
        ;;
    3)
        echo "Running style check and tests..."
        ./vendor/bin/pint -v
        ./vendor/bin/pest
        ;;
    *)
        echo "Invalid option selected. Please run the script again and choose a valid option."
        ;;
esac