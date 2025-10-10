CREATE TABLE RapPrices (
    Id INT IDENTITY PRIMARY KEY,
    Shape NVARCHAR(50),
    Color NVARCHAR(5),
    Clarity NVARCHAR(10),
    LowSize DECIMAL(10,2),
    HighSize DECIMAL(10,2),
    Price INT,
    CONSTRAINT UQ_Rap UNIQUE (Shape, Color, Clarity, LowSize, HighSize)
);


select * from RapPrices;


USE test;
GO

EXEC sp_configure 'show advanced options', 1;
RECONFIGURE;
EXEC sp_configure 'Ad Hoc Distributed Queries', 1;
RECONFIGURE;

TRUNCATE TABLE RapPrices;
GO

DECLARE @json NVARCHAR(MAX);

-- Load JSON file into variable
SELECT @json = BulkColumn
FROM OPENROWSET (BULK 'C:\data\RapPriceLatestResponse.json', SINGLE_CLOB) AS j;

-- Insert data with correct mapping
INSERT INTO dbo.RapPrices (Shape, Color, Clarity, LowSize, HighSize, Price)
SELECT 
    JSON_VALUE(value, '$.shape'),
    JSON_VALUE(value, '$.color'),
    JSON_VALUE(value, '$.clarity'),
    CAST(JSON_VALUE(value, '$.low_size') AS DECIMAL(10,2)),
    CAST(JSON_VALUE(value, '$.high_size') AS DECIMAL(10,2)),
    TRY_CAST(JSON_VALUE(value, '$.caratprice') AS INT)   -- 👈 FIXED
FROM OPENJSON(@json);



CREATE OR ALTER VIEW dbo.VRapPricePivot
AS
SELECT
    Shape,
    Color,
    LowSize,
    HighSize,
    MAX(CASE WHEN LOWER(Clarity)='if'   THEN Price END)  AS [IF],
    MAX(CASE WHEN LOWER(Clarity)='vvs1' THEN Price END)  AS [VVS1],
    MAX(CASE WHEN LOWER(Clarity)='vvs2' THEN Price END)  AS [VVS2],
    MAX(CASE WHEN LOWER(Clarity)='vs1'  THEN Price END)  AS [VS1],
    MAX(CASE WHEN LOWER(Clarity)='vs2'  THEN Price END)  AS [VS2],
    MAX(CASE WHEN LOWER(Clarity)='si1'  THEN Price END)  AS [SI1],
    MAX(CASE WHEN LOWER(Clarity)='si2'  THEN Price END)  AS [SI2],
    MAX(CASE WHEN LOWER(Clarity)='i1'   THEN Price END)  AS [I1],
    MAX(CASE WHEN LOWER(Clarity)='i2'   THEN Price END)  AS [I2],
    MAX(CASE WHEN LOWER(Clarity)='i3'   THEN Price END)  AS [I3]
FROM dbo.RapPrices
GROUP BY Shape, Color, LowSize, HighSize;


select * from VRapPricePivot;
