--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `name`, `code`, `image`, `price`) VALUES
(101, 'Green Love Crostini', 'Green101', 'product-images/1.png', 500.00),
(102, 'Gourmet Yam Taohu', 'Gourmet102', 'product-images/13.png', 600.00),
(103, 'Crispy Gnocchi', 'Crispy103', 'product-images/11.png', 600.00),
(104, 'Lentil Caviar', 'Lentil104', 'product-images/8.png', 650.00),
(105, 'Luxur Oyster', 'Luxur105', 'product-images/4.png', 750.00),
(106, 'Rigatoni Cavolfiore', 'Rigatoni106', 'product-images/3.png', 560.00);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;