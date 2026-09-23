ID: 1 — Scenario 1: Sample Registration with Valid Data
Given that I am on the sample registration page;
When I enter a valid pH value;
And I enter a valid residual chlorine value;
And I enter a valid temperature;
And I submit the sample data;
Then the system should receive the data;
And the parameters should be processed correctly;
And the results should be presented to the user.
Expected Result: The correct calculation result should be displayed.
ID: 2 — Scenario 2: Parameter Validation with Valid Values
Precondition: The test user has been previously registered.
Given that I am on the sample registration page;
When I enter valid values for pH, residual chlorine, and temperature;
And I submit the data;
Then the system should accept the values;
And the parameters should be processed correctly.
Expected Result: The data should be accepted and processed correctly.

Description: pH Classification
ID: 3 — Scenario 1: pH Within the Reference Range
Precondition: The test user is registered.
Given that I am on the sample analysis page;
When I enter a pH value within the reference range;
And I submit the value for analysis;
Then the system should classify the pH according to the established range.
ID: 4 — Scenario 2: pH at the Lower Boundary
Given that I am on the sample analysis page;
When I enter a pH value exactly equal to the lower boundary of the reference range;
And I submit the value for analysis;
Then the system should return the classification defined for that boundary.
ID: 5 — Scenario 3: pH at the Upper Boundary
Given that I am on the sample analysis page;
When I enter a pH value exactly equal to the upper boundary of the reference range;
And I submit the value for analysis;
Then the system should return the classification defined for that boundary.

Description: pH Classification Within the Reference Range
ID: 6 — Scenario 1: pH Classification
Given that there is a water sample under analysis;
When I enter a pH value within the reference range defined for the calculation;
Then the system should return the calculation result.
ID: 7 — Scenario 2: pH Outside the Reference Range
Given that I am on the sample analysis page;
When I enter a pH value outside the reference range;
And I submit the value for analysis;
Then the system should identify that the value is outside the reference range;
And it should return the corresponding classification.

Description: Residual Chlorine Classification
ID: 8 — Scenario 1: Residual Chlorine Within the Reference Range
Given that I am on the sample analysis page;
When I enter a residual chlorine value within the reference range;
And I submit the value for analysis;
Then the system should classify the parameter correctly.
ID: 9 — Scenario 2: Residual Chlorine at the Range Boundary
Given that I am on the sample analysis page;
When I enter a residual chlorine value exactly equal to the established boundary;
And I submit the value for analysis;
Then the system should return the classification corresponding to that boundary.
ID: 10 — Scenario 3: Residual Chlorine Outside the Reference Range
Given that I am on the sample analysis page;
When I enter a residual chlorine value outside the reference range;
And I submit the value for analysis;
Then the system should identify the value as being outside the reference range;
And it should return the corresponding classification.

Description: Temperature Processing and Classification
ID: 11 — Scenario 1: Valid Temperature
Given that I am on the sample analysis page;
When I enter a valid temperature;
And I submit the value for analysis;
Then the system should process the temperature correctly;
And it should return its classification according to the defined criteria.
ID: 12 — Scenario 2: Temperature at the Established Boundary
Given that I am on the sample analysis page;
When I enter a temperature exactly equal to the defined boundary;
And I submit the value for analysis;
Then the system should return the classification corresponding to that boundary.
ID: 13 — Scenario 3: Temperature Outside the Defined Criteria
Given that I am on the sample analysis page;
When I enter a temperature outside the defined criteria;
And I submit the value for analysis;
Then the system should identify the condition;
And it should return the corresponding classification.

ID: 14 — Scenario 4: Physically Invalid pH
Given that I am on the sample analysis page;
When I enter a physically impossible pH value;
And I submit the form;
Then the system should reject the value;
And it should display an error message.

Description: Final Approval Result
ID: 15 — Scenario 1: Invalid Residual Chlorine
Given that I am on the sample analysis page;
When I enter an invalid residual chlorine value;
And I submit the form;
Then the system should reject the value;
And it should display an error message.
ID: 16 — Scenario 2: Invalid Temperature
Given that I am on the sample analysis page;
When I enter a temperature value considered invalid by the system;
And I submit the form;
Then the system should reject the value;
And it should display an error message.

Description: Missing Required Fields
ID: 17 — Scenario 1: pH Field Not Filled In
Given that I am on the sample registration page;
When I do not enter any value in the pH field;
And I fill in the other required fields;
And I submit the data;
Then the system should identify that the pH field is empty;
And it should display an error message;
And it should not process the sample.
ID: 18 — Scenario 2: Residual Chlorine Field Not Filled In
Given that I am on the sample registration page;
When I do not enter any value in the residual chlorine field;
And I fill in the other required fields;
And I submit the data;
Then the system should identify the missing field;
And it should display an error message;
And it should not process the sample.
ID: 19 — Scenario 3: Temperature Field Not Filled In
Given that I am on the sample registration page;
When I do not enter any value in the temperature field;
And I fill in the other required fields;
And I submit the data;
Then the system should identify the missing field;
And it should display an error message;
And it should not process the sample.

Description: Results Display
ID: 20 — Scenario 1: Measurement Results Display
Given that a sample has been filled in with valid data;
When the system processes the parameters;
Then the measurement results should be displayed on the screen;
And the pH classification should be displayed;
And the residual chlorine classification should be displayed;
And the temperature classification should be displayed.
ID: 21 — Scenario 2: Error Display for Invalid Data
Given that a sample contains one or more invalid values;
When the user submits the data for processing;
Then the system should display an error message;
And the invalid result should not be presented as a valid measurement.
