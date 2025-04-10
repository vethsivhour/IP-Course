class CategoryTest extends TestCase
{
    /**
     * Test ID : Category-001
     * Description: Check if we can access the get all categories api
     * Precondition: None
     * Test Steps: 1. Hit the get all categories api
     *             2. Check if the response status is 200
     * Test Data : None
     * Expected Result: The response status should be 200
     * Actual Result: The response status is 200
     * Status: Passed
     * Remark: None
     */

    /**
     * Test ID : Category-002
     * Description: Verify creating a new category with valid data
     * Precondition: User must have admin privileges
     * Test Steps: 1. Send POST request to create category endpoint
     *             2. Check response status
     *             3. Verify category exists in database
     * Test Data : name: "Electronics", description: "Electronic devices"
     * Expected Result: Category should be created with 201 status
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-003
     * Description: Attempt to create category with duplicate name
     * Precondition: Category "Electronics" already exists
     * Test Steps: 1. Send POST request with existing category name
     *             2. Verify error response
     * Test Data : name: "Electronics", description: "Test description"
     * Expected Result: 400 Bad Request with appropriate error message
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-004
     * Description: Update existing category information
     * Precondition: Category with ID 1 exists
     * Test Steps: 1. Send PUT request to update category
     *             2. Verify response status
     *             3. Check updated information
     * Test Data : id: 1, name: "Updated Electronics", description: "New description"
     * Expected Result: Category should be updated with 200 status
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-005
     * Description: Delete existing category
     * Precondition: Category with ID 1 exists
     * Test Steps: 1. Send DELETE request
     *             2. Verify response status
     *             3. Confirm category no longer exists
     * Test Data : id: 1
     * Expected Result: Category should be deleted with 200 status
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-006
     * Description: Get single category by ID
     * Precondition: Category with ID 1 exists
     * Test Steps: 1. Send GET request for specific category
     *             2. Verify response status and data
     * Test Data : id: 1
     * Expected Result: Return category details with 200 status
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-007
     * Description: Create category with invalid data (empty name)
     * Precondition: None
     * Test Steps: 1. Send POST request with empty name
     *             2. Verify error response
     * Test Data : name: "", description: "Test description"
     * Expected Result: 400 Bad Request with validation error
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-008
     * Description: Update non-existent category
     * Precondition: None
     * Test Steps: 1. Send PUT request for non-existent ID
     *             2. Verify error response
     * Test Data : id: 999, name: "Test", description: "Test"
     * Expected Result: 404 Not Found response
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-009
     * Description: Get categories with pagination
     * Precondition: At least 15 categories exist
     * Test Steps: 1. Send GET request with page parameters
     *             2. Verify pagination data
     * Test Data : page: 1, limit: 10
     * Expected Result: Return 10 categories with pagination metadata
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */

    /**
     * Test ID : Category-010
     * Description: Search categories by name
     * Precondition: Multiple categories exist
     * Test Steps: 1. Send GET request with search parameter
     *             2. Verify filtered results
     * Test Data : search: "Elec"
     * Expected Result: Return only categories containing "Elec"
     * Actual Result: To be filled
     * Status: Pending
     * Remark: None
     */
}