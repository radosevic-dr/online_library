#!/bin/bash

# Function to list all local git branches
list_branches() {
    branches=($(git branch | cut -c 3-))
    echo "Local Git Branches:"
    for i in "${!branches[@]}"; do
        echo "$i. ${branches[$i]}"
    done
}

# Display menu of options
display_menu() {
    echo "Select an action:
1. List all branches
2. Checkout existing branch
3. Create new branch
4. Delete branch
5. Exit"
}

# Main script
while true; do
    display_menu
    read -p ">>> Enter your choice (1/2/3/4/5): " choice

    case $choice in
        1)
            list_branches
            ;;
        2)
            list_branches
            read -p ">>> Enter the number of the branch you want to checkout: " branch_number
            if [[ $branch_number =~ ^[0-9]+$ && $branch_number -ge 0 && $branch_number -lt ${#branches[@]} ]]; then
                selected_branch=${branches[$branch_number]}
                git checkout $selected_branch
            else
                echo ">>> Invalid branch number"
            fi
            ;;
        3)
            read -p ">>> Enter the name of the new branch: " new_branch
            git checkout -b $new_branch
            ;;
        4)
            list_branches
            read -p ">>> Enter the number of the branch you want to delete: " branch_number
            if [[ $branch_number =~ ^[0-9]+$ && $branch_number -ge 0 && $branch_number -lt ${#branches[@]} ]]; then
                selected_branch=${branches[$branch_number]}
                git branch -d $selected_branch
            else
                echo ">>> Invalid branch number"
            fi
            ;;
        5)
            echo ">>> Exiting"
            exit 0
            ;;
        *)
            echo ">>> Invalid choice, please try again"
            ;;
    esac
done
