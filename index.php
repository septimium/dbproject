<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>GreenTechNex</title>
</head>
<body>

    <center>
        
    <div class="topbar">
        <h1>GreenTechNex</h1>
    </div>

    <div class="options">
        <button onclick="runQuery('SELECT C.CompanyName, P.ProjectName, I.InstituteName FROM Companies C JOIN CompaniesProjects CP ON C.CompanyID = CP.CompanyID JOIN Projects P ON CP.ProjectID = P.ProjectID JOIN Collaborations COL ON P.ProjectID = COL.ProjectID JOIN ResearchInstitutes I ON COL.InstituteID = I.InstituteID WHERE I.Location = \'Ohio\'')">Projects in Ohio</button>
        <button onclick="runQuery('SELECT C.CompanyName, CE.CertificationName, CE.Description FROM Companies C JOIN Certifications CE ON C.CompanyID = CE.CompanyID JOIN CertifiedTechnologies CT ON CE.CertificationID = CT.CertificationID JOIN Technologies T ON CT.TechID = T.TechID JOIN EnvironmentalImpactMetrics E ON T.TechID = E.TechID WHERE E.CO2Reduction > 85')">Eco-friendly Certifications</button>
        <button onclick="runQuery('SELECT R.FirstName, R.LastName, P.ProjectName, P.StartDate FROM Researchers R JOIN ResearchersProjects RP ON R.ResearcherID = RP.ResearcherID JOIN Projects P ON RP.ProjectID = P.ProjectID JOIN TechnologyImplementations TI ON P.ProjectID = TI.ProjectID JOIN Technologies T ON TI.TechID = T.TechID JOIN TechnologyCategories TC ON T.CategoryID = TC.CategoryID WHERE TC.CategoryName = \'Hardware\' AND P.StartDate > STR_TO_DATE(\'2023-01-01\', \'%Y-%m-%d\')')">Hardware Projects after 2023</button>    <button onclick="runQuery('SELECT C.CompanyName, P.ProjectName, RAP.ApprovalID FROM Companies C JOIN CompaniesProjects CP ON C.CompanyID = CP.CompanyID JOIN Projects P ON CP.ProjectID = P.ProjectID JOIN TechnologyImplementations TI ON P.ProjectID = TI.ProjectID JOIN RegulatoryApprovals RAP ON TI.TechID = RAP.TechID JOIN RegulatoryAgencies RAG ON RAP.AgencyID = RAG.AgencyID WHERE RAG.AgencyName = \'Environmental Protection Agency\'')">Projects Approved by EPA</button>
        <button onclick="runQuery('SELECT T.TechName, C.CompanyName FROM Technologies T JOIN CertifiedTechnologies CT ON T.TechID = CT.TechID JOIN Certifications CE ON CT.CertificationID = CE.CertificationID JOIN Companies C ON CE.CompanyID = C.CompanyID WHERE T.TechName LIKE \'%AI%\' OR T.TechName LIKE \'%Web%\'')">Technologies with AI or Web Trends</button>
        <button onclick="runQuery('SELECT CT.CertTechID, T.TechName, CE.CertificationName, C.CompanyName FROM CertifiedTechnologies CT JOIN Technologies T ON CT.TechID = T.TechID JOIN Certifications CE ON CT.CertificationID = CE.CertificationID JOIN Companies C ON CE.CompanyID = C.CompanyID WHERE T.Description LIKE \'%sustainability%\' AND C.Location = \'New York\'')">Sustainable Technologies in New York</button>
        <button onclick="runQuery('SELECT P.ProjectName, C.CompanyName, FS.SourceName, SUM(FP.Amount) AS TotalFunding FROM Projects P JOIN CompaniesProjects CP ON P.ProjectID = CP.ProjectID JOIN Companies C ON CP.CompanyID = C.CompanyID JOIN FundedProjects FP ON P.ProjectID = FP.ProjectID JOIN FundingSources FS ON FP.SourceID = FS.SourceID GROUP BY P.ProjectID, P.ProjectName, C.CompanyName, FS.SourceName ORDER BY TotalFunding DESC')">Total Funding for Projects</button>
        <button onclick="runQuery('SELECT T.TechName, AVG(UF.Rating) AS AvgRating FROM Technologies T JOIN UserFeedback UF ON T.TechID = UF.TechID JOIN TechnologyImplementations I ON T.TechID = I.TechID GROUP BY T.TechID, T.TechName HAVING AVG(UF.Rating) = (SELECT MAX(AvgRating) FROM (SELECT T1.TechID, AVG(UF1.Rating) AS AvgRating FROM Technologies T1 JOIN UserFeedback UF1 ON T1.TechID = UF1.TechID JOIN TechnologyImplementations I1 ON T1.TechID = I1.TechID GROUP BY T1.TechID) Subquery)')">Top-Rated Technologies</button>
        <button onclick="runQuery('SELECT T.TechName, R.LastName, AVG(UF.Rating) AS AvgRating FROM Technologies T JOIN TechnologyImplementations TI ON T.TechID = TI.TechID JOIN Projects P ON TI.ProjectID = P.ProjectID JOIN ResearchersProjects RP ON P.ProjectID = RP.ProjectID JOIN Researchers R ON RP.ResearcherID = R.ResearcherID JOIN UserFeedback UF ON T.TechID = UF.TechID JOIN RegulatoryApprovals RA ON T.TechID = RA.TechID WHERE UF.DateAdded >= (CURDATE() - INTERVAL 3 MONTH) GROUP BY T.TechID, R.ResearcherID, T.TechName, R.LastName ORDER BY AvgRating DESC')">Top-Rated Technologies in Last 3 Months</button>
        <button onclick="runQuery('SELECT R.FirstName, R.LastName, T.TechName FROM ResearchInstitutes RI JOIN Researchers R ON RI.InstituteID = R.InstituteID JOIN ResearchersProjects RP ON R.ResearcherID = RP.ResearcherID JOIN TechnologyImplementations TI ON RP.ProjectID = TI.ProjectID JOIN Technologies T ON TI.TechID = T.TechID JOIN TechnologyCategories TC ON T.CategoryID = TC.CategoryID WHERE TC.CategoryName = \'AI\' AND RI.Location = \'Pennsylvania\'')">AI Technologies in Pennsylvania</button>
    </div>

    <div id="result"></div>

    </center>
    <script>


        function runQuery(sqlQuery) {
            // Make an AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the result div with the response from the server
                    document.getElementById("result").innerHTML = xhr.responseText;
                    result.classList.add('active');
                }
            };
            xhr.open("GET", "database.php?sql=" + encodeURIComponent(sqlQuery), true);
            xhr.send();
        }
    </script>
</body>
</html>